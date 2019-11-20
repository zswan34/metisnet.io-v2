import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import ErrorComponent from "../errors/ErrorComponent";
import StandardLoadingComponent from "../loading/StandardLoadingComponent";
import DomainRecordItem from "./DomainRecordItem";
import EditRecordItemModal from "../modals/EditRecordItemModal";

const AUTH_USER_URL = '/api/v1/auth/';
const DNS_ITEMS_SERVICE_URL = '/api/v1/domains/';

export default class DomainRecords extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            hasError: false,
            isLoaded: false,
            authUser: [],
            permissions: [],
            roles: [],
            records: [],
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
                    authUser: result.auth,
                    permissions: result.auth.permissions,
                    roles: result.auth.roles
                })
            )
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    fetchrecords() {
        // Where we're fetching data from
        fetch(DNS_ITEMS_SERVICE_URL + this.domainUid() + '/' + this.domainName())
        // We get the API response and receive data in JSON format...
            .then(response => response.json())
            // ...then we update the users state
            .then(result =>

                this.setState({
                    isLoaded: true,
                    records: result[0].domain,
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
        this.fetchrecords();
    }


    addSubdomainButton () {
        if (this.state.roles.includes('member')) {
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

    userHasPermission(permission) {
        const permissions = this.state.permissions;
        let match = false;
        for(let i = 0; i < permissions.length; i++) {
            if (permissions[i].name === permission) {
                match = true;
            }
        }
        return match;
    }

    updateRecords() {
        this.fetchrecords();
    }

    render() {
        if (this.state.hasError) {
            return (
                <ErrorComponent/>
            )
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
                                    {this.state.records.dns.map((dns, index) => {
                                        return (
                                            <DomainRecordItem updateRecords={this.updateRecords.bind(this)} user={this.state.authUser} record={dns} key={index} />
                                        )
                                    })}
                                </div>
                            </div>
                        </div>
                        <div>
                            { /* this.state.records.dns.map((dns, index) => {
                                return (
                                    <EditRecordItemModal updateRecords={this.updateRecords.bind(this)}
                                                         details={this.state.details} account={this.state.account}
                                                         records={this.state.records} record={dns} key={index}
                                                         axios={axios}/>
                                )
                            }) */}
                        </div>
                    </div>
                )
            } else {
                return (
                    <StandardLoadingComponent/>
                )
            }
        }
    }
}


if (document.getElementById('godaddy-domain-dns-items')) {
    ReactDOM.render(<DomainRecords />, document.getElementById('godaddy-domain-dns-items'));
}
