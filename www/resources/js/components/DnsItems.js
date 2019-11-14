import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import AuthUser from "./AuthUser";

const AUTH_USER_URL = '/api/v1/auth/';
const DNS_ITEMS_SERVICE_URL = '/api/v1/domains/';

export default class DnsItems extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            hasError: false,
            isLoaded: false,
            authUser: [],
            dnsItems: [],
            account: [],
            timezone: [],
            details: []
        };
    }

    fetchAuthUser() {
        fetch(AUTH_USER_URL)
            .then(response => response.json())
            .then(result =>
                this.setState({
                    authUser: result.auth
                })
            )
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    fetchDnsItems() {
        // Where we're fetching data from
        fetch(DNS_ITEMS_SERVICE_URL + this.domainUid() + '/' + this.domainName())
        // We get the API response and receive data in JSON format...
            .then(response => response.json())
            // ...then we update the users state
            .then(result =>

                this.setState({
                    isLoaded: true,
                    dnsItems: result[0].domain,
                    account: result[0].domain.account,
                    timezone: result[0].domain.timezone,
                    details: result[0].domain.details,
                    hasError: false
                })
            )

            // Catch any errors we hit and update the app
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    domainUid() {
        let url = window.location.pathname;
        url = url.split('/')[2];
        return url;
    }

    domainName() {
        let url = window.location.pathname;
        url = url.split('/')[3];
        return url;
    }

    componentDidMount() {
        this.fetchAuthUser();
        this.fetchDnsItems();
    }

    errorHasOccurred() {
        return (
            <div>
                <p className="text-danger">Oops.. An error occurred...</p>
            </div>
        )
    }


    addSubdomainButton () {
        if (this.state.authUser.roles.includes('member')) {
            return (
                <div>
                    <button type="button" className="btn d-block btn-primary rounded-pill waves-effect"
                            data-toggle="modal" data-target="#add-record-button">
                        <span className="ion ion-md-add"></span>&nbsp; Add Record
                    </button>
                </div>
            )
        } else {
            return (
                <div>
                    <p>Oops</p>
                </div>
            )
        }
    }

    arrayLookup(searchValue,array,searchIndex,returnIndex)
    {
        let returnVal = null;
        let i;
        for(i=0; i<array.length; i++)
        {
            if(array[i][searchIndex]===searchValue)
            {
                returnVal = array[i][returnIndex];
                break;
            }
        }

        return returnVal;
    }

    userHasPermission(permission) {
        const permissions = this.state.authUser.permissions;
        let match = false;
        for(let i = 0; i < permissions.length; i++) {
            if (permissions[i].name === permission) {
                match = true;
            }
        }
        return match;
    }


    displayControls() {
        const canEdit = this.userHasPermission('edit domain records');
        const canDelete = this.userHasPermission('delete domain records');

        return (
            <div className={"d-block"}>
                { canEdit ? (
                <button type={"button"} className={"btn btn-warning btn-sm px-2 mx-1"}>
                    <i className="lnr lnr-pencil"></i></button>
                    ) : null }
                { canDelete ? (
                    <button type={"button"} className={"btn btn-danger btn-sm px-2 mx-1"}>
                        <i className="lnr lnr-trash"></i></button>
                    ) : null}
            </div>
        )
    }

    render() {
        if (this.state.hasError) {
            return this.errorHasOccurred();
        } else {
            if (this.state.isLoaded) {
                console.log(this.state);
                return (
                    <div>
                        <ol className="breadcrumb">
                            <li className="breadcrumb-item">
                                <a href="/domains/">Domains</a>
                            </li>
                            <li className="breadcrumb-item">
                                <a href={"/domains/" + this.domainUid()}>{this.domainUid()}</a>
                            </li>
                            <li className="breadcrumb-item active">{`${this.domainName()}`}</li>
                        </ol>
                        <h4 className="d-flex justify-content-between align-items-center w-100 font-weight-bold pt-3 mb-0">
                            <div>{`${this.state.account.nickname}`}</div>
                            { this.addSubdomainButton() }
                        </h4>
                        <small className={"text-muted mb-4"}>Company: Godaddy</small>
                        <div className={"row"}>
                            <div className="card-body">
                            <div className="font-weight-semibold mb-3">Subdomains</div>
                                <div className="list-group">
                                    {this.state.dnsItems.dns.map((dns, index) => {
                                        return (
                                            <div className="list-group-item list-group-item-action flex-column align-items-start" key={index}>
                                                <div className="d-flex justify-content-between w-100">
                                                    <h5 className="mb-1">{`${dns.name}`}</h5>
                                                    {this.displayControls()}
                                                </div>
                                                <div className={"small"}><b><i>Host: </i></b>  {`${dns.data}`}</div>
                                                <div className={"small"}><b><i>Type: </i></b> {`${dns.type}`}</div>
                                            </div>
                                        )
                                    })}
                                </div>
                            </div>
                        </div>
                    </div>
                )
            } else {
                return (
                    <div>
                        <p>Loading...</p>
                    </div>
                )
            }
        }
    }
}


if (document.getElementById('godaddy-domain-dns-items')) {
    ReactDOM.render(<DnsItems />, document.getElementById('godaddy-domain-dns-items'));
}
