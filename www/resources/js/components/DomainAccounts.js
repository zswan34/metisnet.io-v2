import React, { Component } from 'react';
import ReactDOM from 'react-dom';

const AUTH_USER_URL = '/api/v1/auth/';
const SERVER_SERVICE_URL = '/api/v1/domains/';

export default class DomainAccounts extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            hasError: false,
            isLoaded: false,
            authUser: [],
            domains: [],
            domain: []
        };
    }

    fetchDomains() {
        // Where we're fetching data from
        fetch(SERVER_SERVICE_URL)
        // We get the API response and receive data in JSON format...
            .then(response => response.json())
            // ...then we update the users state
            .then(result =>
                this.setState({
                    isLoaded: true,
                    domains: result,
                    hasError: false
                })
            )
            // Catch any errors we hit and update the app
            .catch(error => this.setState({ error, isLoaded: false, hasError: true }));
    }

    fetchDomainById(uid) {
        fetch(SERVER_SERVICE_URL + uid)
            // We get the API response and receive data in JSON format...
            .then(response => response.json())
            // ...then we update the users state
            .then(result =>
                this.setState({
                    isLoaded: true,
                    domain: result,
                    hasError: false
                })
            )
            // Catch any errors we hit and update the app
            .catch(error => this.setState({ error, isLoaded: false, hasError: true }));
    }

    fetchAuthUser() {
        axios.get(AUTH_USER_URL)
            .then(response => response.json())
            .then(result =>
                this.setState({
                    authUser: result.auth
                })
            )
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    componentDidMount() {
        this.fetchAuthUser();
        this.fetchDomains();

        let form = $("#create-account-form");
        let modal = $("#create-domain-account");

        form.submit((e) => {
            e.preventDefault();
            let data = form.serialize();
            let path = form.attr('action');
            axios.post('/domains', data)
                .then((res) => {

                    const data = res.data;
                    if (data.success) {
                        modal.modal('hide');
                        this.fetchDomains();
                    }
                })
        });
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

    editAccount(uid) {
        this.fetchDomainById(uid);
        if (this.userHasPermission('edit domain account')) {

        }
    }

    editAccountModal() {
        return (
            <div>
                <div className="modal" id={"edit-domain-account-modal"} tabIndex="-1" role="dialog">
                    <div className="modal-dialog" role="document">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title">Modal title</h5>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <p>Modal body text goes here.</p>
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="btn btn-primary">Save changes</button>
                                <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }

    deleteAccount(uid) {
        if (this.userHasPermission('delete domain account')) {

        }
    }

    accountOptions(uid) {

        const canEdit = this.userHasPermission('edit domain account');
        const canDelete = this.userHasPermission('delete domain account');

        return (
            <div className={"d-block"}>
                { canEdit ? (
                    <button onClick={this.editAccount(uid)} type={"button"}
                            className={"btn px-2 btn-xs btn-warning mx-1"} data-toggle="modal"
                            data-target="#edit-domain-account-modal">
                        <span className="ion ion-md-eye"></span> Edit</button>
                ) : null }
                { canDelete ? (
                    <button onClick={this.deleteAccount(uid)} type={"button"} className={"btn btn-danger btn-xs px-2 mx-1"}>
                        <span className="lnr lnr-trash"></span> Delete</button>
                ) : null}
            </div>
        )
    }

    render() {
        if (this.state.isLoaded) {
            console.log(this.state);
            return (
                <div>
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item">
                            <a href="#">Domains</a>
                        </li>
                    </ol>
                    <h4 className="d-flex justify-content-between align-items-center w-100 font-weight-bold py-3 mb-4">
                        <div>Domain Name Servers</div>
                        { this.userHasPermission('add domain account') ? (
                        <button type="button" className="btn d-block btn-primary rounded-pill waves-effect"
                                data-toggle="modal" data-target="#create-domain-account">
                            <span className="ion ion-md-add"></span>&nbsp; Add Account
                        </button>
                        ): null}
                    </h4>

                    <div className={"row"}>
                        {this.state.domains.map((domain, index) => {
                            let name = '';
                            let logo = '';
                            if (domain.type === 'godaddy') {
                                name = 'Go Daddy';
                                logo = '/assets/brands/godaddy.png';
                            }

                            if (domain.type === 'google') {
                                name = 'Google Domains';
                                logo = '/assets/brands/godaddy.png';
                            }

                            return (
                                <div className="col-md-6" key={index}>
                                    <div className="card mb-3">
                                        <div className="card-body">
                                            <div className="card-title with-elements">
                                                <h5 className="m-0 mr-2">{`${ domain.nickname }`}</h5>
                                                <div className="card-title-elements ml-md-auto">

                                                    {this.accountOptions(domain.uid)}
                                                </div>
                                            </div>
                                            <div className="d-flex justify-content-start">
                                                <img src={`${logo}`} alt={"Godaddy"} style={{height: "100px"}}/>
                                                <div className="flex ml-3">
                                                    <h4 className="card-title">{`${domain.nickname}`}</h4>
                                                    <div className="card-subtitle text-muted">
                                                        {`${ name }`}
                                                    </div>
                                                    <a className={"mt-2"} href={"/domains/" + domain.uid}
                                                       style={{fontSize: ".8rem"}}>View</a>
                                                </div>
                                            </div>

                                            <p className="card-text">Lorem ipsum dolor sit amet, idque nostro eirmod qui at.</p>
                                        </div>
                                    </div>
                                </div>
                            )
                        })}

                    </div>

                    {this.editAccountModal()}

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

if (document.getElementById('domain-account-wrapper')) {
    ReactDOM.render(<DomainAccounts />, document.getElementById('domain-account-wrapper'));
}
