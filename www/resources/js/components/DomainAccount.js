import React, { Component } from 'react';
import ReactDOM from 'react-dom';

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
                    authUser: result.auth
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

    errorHasOccurred() {
        return (
            <div>
                <p className="text-danger">Oops.. An error occurred...</p>
            </div>
        )
    }

    buyDomainButton() {
        if (this.state.authUser.roles.includes('member')) {
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
            return this.errorHasOccurred();
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
                                let renewDeadlineColor = '';
                                let domain = d.domain;
                                console.log(domain);
                                let now = moment.tz(this.state.timezone);
                                let renewDeadline = moment.tz(domain.details.renewDeadline, this.state.timezone);
                                if (now > (renewDeadline.subtract(3, 'months'))) {
                                    renewDeadlineColor = 'text-info';
                                }

                                if (now > (renewDeadline.subtract(1, 'month'))) {
                                    renewDeadlineColor = 'text-danger';
                                }

                                return <div className="col-sm-6 col-md-4 col-lg-6 col-xl-4" key={index}>

                                    <div className="border-light ui-bordered bg-white p-3 mt-2">
                                        <div className="media align-items-center">
                                            <div className="media-body small mr-3">
                                                <div className="font-weight-semibold mb-3" style={{fontSize: '1rem'}}>
                                                    <a href={"/domains/" + this.domainUid() + '/' + domain.domain_info.domain}>
                                                        {`${domain.domain_info.domain}`}</a></div>
                                                <div className="">Subdomains: {`${domain.dns.length - 1}`}</div>
                                                <div>Purchased: {`${ moment.tz(domain.details.createdAt, this.state.timezone)
                                                    .format('LL') }`}</div>
                                                <div className="mb-2">IP Address: {`${domain.dns[0].data}`}</div>
                                                <div className={renewDeadlineColor}>Renewal Date: {`${renewDeadline.format('LL')}`}</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            })}
                        </div>
                    </div>
                )
            }
            else {
                return (
                    <div>
                        <p>Loading...</p>
                    </div>
                )
            }
        }
    }
}

if (document.getElementById('godaddy-domain-account-wrapper')) {
    ReactDOM.render(<DomainAccount />, document.getElementById('godaddy-domain-account-wrapper'));
}
