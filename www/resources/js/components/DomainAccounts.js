import React, { Component } from 'react';
import ReactDOM from 'react-dom';

const SERVER_SERVICE_URL = '/api/v1/domains';

export default class DomainAccounts extends Component {
    constructor(props) {
        super(props);
        this.state = {
            error: null,
            hasError: false,
            isLoaded: false,
            authuser: [],
            dnsItems: []
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

    componentDidMount() {
        this.fetchDomains();
    }

    handleSaveChanges(e) {
        console.log(e);

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
        })
    }

    render() {
        if (this.state.isLoaded) {
            return (
                <div>
                    <ol className="breadcrumb">
                        <li className="breadcrumb-item">
                            <a href="#">Domains</a>
                        </li>
                    </ol>
                    <h4 className="d-flex justify-content-between align-items-center w-100 font-weight-bold py-3 mb-4">
                        <div>Domain Name Servers</div>
                        <button type="button" className="btn d-block btn-primary rounded-pill waves-effect"
                                data-toggle="modal" data-target="#create-domain-account">
                            <span className="ion ion-md-add"></span>&nbsp; Add Account
                        </button>
                    </h4>
                    <div className={"row"}>
                        {this.state.domains.map(function (domain, index) {
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

                            return <div className="col-6" key={domain.id}>
                                <div className="card mb-4">
                                    <div className="card-body">
                                        <div className="d-flex justify-content-start">
                                            <img src={`${logo}`} alt={"Godaddy"} style={{height: "100px"}}/>
                                            <div className="flex ml-3">
                                                <h4 className="card-title">{`${domain.nickname}`}</h4>
                                                <div className="card-subtitle text-muted">
                                                    {`${ name }`}
                                                </div>
                                                <a className={"mt-2"} href={"/domains/" + domain.uid}
                                                   style={{fontSize: ".8rem"}}>Setup</a>
                                            </div>
                                        </div>
                                        <p className="card-text mt-2">Some quick example text to build on the card title
                                            and make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                            </div>
                        })}
                    </div>
                    <div className="modal fade" id="create-domain-account" tabIndex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div className="modal-dialog" role="document">
                            <form id="create-account-form" action="/domains/" method={"post"}>
                                <div className="modal-content">
                                    <div className="modal-header">
                                        <h5 className="modal-title" id="exampleModalLabel">Add an account</h5>
                                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div className="modal-body">
                                        <div className="form-group">
                                            <label htmlFor="account-nickname">Nickname</label>
                                            <input className="form-control" type="text" id="account-nickname"
                                                   name="account-nickname" placeholder="Nickname"/>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="account-type" className="form-label">Type</label>
                                            <select name="domain-account-type" id="account-type" className="select2">
                                                <option value="godaddy">Godaddy</option>
                                                <option value="google">Google Domains</option>
                                            </select>
                                        </div>
                                        <div id="godaddy-options">
                                            <div className="form-group">
                                                <label htmlFor="godaddy-account-api-key" className="form-label">Api
                                                    Key</label>
                                                <input type="text" id="godaddy-account-api-key"
                                                       name="godaddy-account-api-key" className="form-control"
                                                       placeholder="Api Key"/>
                                            </div>
                                            <div className="form-group">
                                                <label htmlFor="godaddy-account-api-secret" className="form-label">Api
                                                    Secret</label>
                                                <input type="text" id="godaddy-account-api-secret"
                                                       name="godaddy-account-api-secret" className="form-control"
                                                       placeholder="Api Secret"/>
                                            </div>
                                        </div>

                                        <div id="google-options" style={{display: 'none'}}>
                                            <p>In progress</p>
                                            <div className="form-group">
                                                <label htmlFor="account-api-key" className="form-label">Api Key</label>
                                                <input type="text" id="account-api-key" name="account-api-key"
                                                       className="form-control" placeholder={"Api Key"}/>
                                            </div>

                                        </div>
                                    </div>
                                    <div className="modal-footer">
                                        <button type="button" className="btn btn-secondary"
                                                data-dismiss="modal">Cancel
                                        </button>
                                        <button type="submit" onSubmit={this.handleSaveChanges()}
                                                className="btn btn-primary">Save changes
                                        </button>
                                    </div>
                                </div>
                            </form>
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

if (document.getElementById('domain-account-wrapper')) {
    ReactDOM.render(<DomainAccounts />, document.getElementById('domain-account-wrapper'));
}
