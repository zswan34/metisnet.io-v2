import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ErrorComponent from "../errors/ErrorComponent";
import StandardLoadingComponent from "../loading/StandardLoadingComponent";
import DomainAccountItem from "./DomainAccountItem";

const AUTH_USER_URL = '/api/v1/auth/';
const SERVER_SERVICE_URL = '/api/v1/domains/';


export default class DomainAccount extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            hasError: false,
            isLoaded: false,
            timezone: [],
            domains: [],
            authUser: [],
            permissions: [],
            roles: [],
            records: []
        };
    }

    domainUid() {
        let url = window.location.pathname;
        url = url.split('/')[2];
        return url;
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

    fetchDomain() {
        // Where we're fetching data from
        fetch(SERVER_SERVICE_URL + this.domainUid())
        // We get the API response and receive data in JSON format...
            .then(response => response.json())
            // ...then we update the users state
            .then(result =>
                this.setState({
                    isLoaded: true,
                    domains: result[0],
                    account: result.account,
                    timezone: result.timezone,
                    hasError: false
                })
            )
            // Catch any errors we hit and update the app
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    componentDidMount() {
        this.fetchAuthUser();
        this.fetchDomain();
    }

    buyDomainButton() {
        if (this.state.roles.includes('member')) {
            return (
                <div>
                    <button type="button" className="btn d-block btn-primary rounded-pill waves-effect"
                            data-toggle="modal" data-target="#buy-domain-button">
                        <span className="ion ion-md-add"></span>&nbsp; Buy Domain
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

    render() {
        if (this.state.hasError) {
            return (
                <ErrorComponent/>
            )
        } else {
            if (this.state.isLoaded) {
                console.log(this.state.authUser);
                return (
                    <div>
                        <ol className="breadcrumb">
                            <li className="breadcrumb-item">
                                <a href="/domains/">Domains</a>
                            </li>
                            <li className="breadcrumb-item active">{`${this.domainUid()}`}</li>
                        </ol>
                        <h4 className="d-flex justify-content-between align-items-center w-100 font-weight-bold pt-3 mb-0">
                            <div>{`${this.state.account.nickname}`}</div>
                            { this.buyDomainButton() }
                        </h4>
                        <small className={"text-muted mb-4"}>Company: Godaddy</small>
                        <div className={"row"}>
                            {this.state.domains.map((d, index) => {
                                console.log(d.domain);
                                return (
                                    <DomainAccountItem domain={d.domain} key={index}/>
                                );
                            })}
                        </div>
                    </div>
                )
            }
            else {
                return (
                    <StandardLoadingComponent/>
                )
            }
        }
    }
}

if (document.getElementById('godaddy-domain-account-wrapper')) {
    ReactDOM.render(<DomainAccount />, document.getElementById('godaddy-domain-account-wrapper'));
}
