<?php

namespace App\Http\Controllers;

use App\DomainAccount;
use App\DomainAccountItem;
use App\Libs\GoDaddy;
use DigitalOceanV2\Api\Domain;
use Illuminate\Http\Request;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class DomainController extends Controller
{
    public function getDomainAccounts() {
        return view('pages.domains.main');
    }

    public function getDomains() {
        return view('pages.domains.show-domain');
    }

    public function getDomainDnsItems() {
        return view('pages.domains.show-dns');
    }

    public function postDomains() {
        $nickname = '';
        $key = '';
        $secret = '';

        $type = request('domain-account-type');
        $user_id = auth()->user()->id;

        if ($type === 'godaddy') {
            $nickname = request('account-nickname');
            $key = request('godaddy-account-api-key');
            $secret = request('godaddy-account-api-secret');
        }

        $domainAccount = new DomainAccount();
        $domainAccount->nickname = $nickname;
        $domainAccount->user_id = $user_id;
        $domainAccount->save();

        $domainItem = new DomainAccountItem();
        $domainItem->type = $type;
        $domainItem->api_key = $key;
        $domainItem->api_secret = $secret;
        $domainItem->domain_account_id = $domainAccount->id;
        $domainItem->save();

        $response = [
            'success' => true,
            'message' => 'Account created successfully'
        ];

        return response()->json($response, 200);
    }

    public function getGodaddyDomains() {
        return view('pages.domains.godaddy');
    }

    public function getDomainAccountsApi() {
        $items = DomainAccount::leftJoin('domain_account_items', 'domain_accounts.id',
            '=', 'domain_account_items.domain_account_id')->get();
        return $items; //DomainAccountItem::leftJoin('domain_accounts', 'domain_account_items.domain_account_id', '=', 'domain_accounts.id')->get();
    }

    public function getDomainsApi($uid) {

        $response = [];
        $details = [];

        $domain = DomainAccount::leftJoin('domain_account_items', 'domain_accounts.id',
            '=', 'domain_account_items.domain_account_id')
            ->where('domain_account_items.uid', $uid)->first();
        if ($domain) {
            if ($domain->type === 'godaddy') {
                if ($godaddy = new GoDaddy($domain->api_key, $domain->api_secret)) {
                    foreach($godaddy->getDomains() as $gd) {
                        if ($gd->status === 'ACTIVE') {
                            $dns = $godaddy->getDnsByType($gd->domain, 'a', false);
                            $data = [
                                'account' => $domain,
                                'details' => $godaddy->getDomain($gd->domain),
                                'domain_info' => $gd,
                                'dns' => json_decode($dns)
                            ];
                            $response[] = ['domain' => $data];
                        }
                    }
                } else {
                        $response[] = ['domain' => ''];
                }

            }
        }
        return [
            'account' => $domain,
            'timezone' => auth()->user()->getTimezone(),
            $response
        ];
    }

    public function getDomainDnsItemsApi($uid, $name)
    {
        $response = [];
        $account = DomainAccount::leftJoin('domain_account_items', 'domain_accounts.id',
            '=', 'domain_account_items.domain_account_id')
            ->where('domain_account_items.uid', $uid)->first();

        if ($account) {
            if ($account->type === 'godaddy') {
                $godaddy = new GoDaddy($account->api_key, $account->api_secret);

                    $domain = $godaddy->getDomain($name);
                    if ($domain) {
                        $dns = $godaddy->getDnsByType($domain->domain, 'a', false);
                        $data = [
                            'account' => $account,
                            'details' => $domain,
                            'dns' => json_decode($dns),
                            'timezone' => auth()->user()->getTimezone(),

                        ];
                    }

                    $response[] = ['domain' => $data];
                }
             return $response;
        }
    }

    public function editDomainAccountApi($uid) {
        $account = DomainAccount::leftJoin('domain_account_items', 'domain_accounts.id',
            '=', 'domain_account_items.domain_account_id')
            ->where('domain_account_items.uid', $uid)->first();
        if ($account) {
            $account->update([
                'nickname' => request('edit-account-nickname'),
                'api_key' => request('edit-godaddy-account-api-key'),
                'api_secret' => request('edit-godaddy-account-api-secret')
            ]);
            if ($account->save()) {

                $response = [
                    'success' => true
                ];
            } else {
                $response = [
                    'success' => false
                ];
            }
        } else {
            $response = [
                'success' => false
            ];
        }
        return response()->json($response);
    }

    public function deleteDomainAccountApi($uid) {
       $account = DomainAccount::leftJoin('domain_account_items', 'domain_accounts.id',
           '=', 'domain_account_items.domain_account_id')
           ->where('domain_account_items.uid', $uid)->first();

       if ($account) {
           $account->delete();

           return [
               'success' => true
           ];
       } else {
           return [
               'success' => false
           ];
       }
    }

    public function editDnsRecordByName($uid, $name) {
        $response = [];
        $host = request('edit-record-item-data');
        $name = request('name');
        $uid = request('uid');
        $domain = request('domain');

        $account = DomainAccount::leftJoin('domain_account_items', 'domain_accounts.id',
            '=', 'domain_account_items.domain_account_id')
            ->where('domain_account_items.uid', $uid)->first();

        if ($account) {
            if ($account->type === 'godaddy') {
                $godaddy = new GoDaddy($account->api_key, $account->api_secret);

                $dns = $godaddy->editDnsRecordByTypeAndName($domain, $name, $host);

                $response[] = ['domain' => $dns];
            }
            return request()->json($response);
        }
    }
}
