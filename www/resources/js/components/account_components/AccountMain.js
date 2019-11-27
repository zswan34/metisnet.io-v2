import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import SearchResults from 'react-filter-search';
import StandardLoadingComponent from "../loading/StandardLoadingComponent";

const AUTH_USER_URL = '/api/v1/auth/';
const USER_API_URL = '/api/v1/users/';

export default class AccountMain extends Component {
    constructor(props) {
        super(props);
        this.state = {
            users: [],
            authUser: [],
            permissions: [],
            isLoaded: false,
            userIsLoading: false,
            hasErrors: false,
            value: '',
            selectedUser: []
        }
    }

    fetchAuthUser() {
        fetch(AUTH_USER_URL)
            .then(response => response.json())
            .then(result =>
                this.setState({
                    authUser: result.auth,
                    permissions: result.auth.permissions
                })
            )
            .catch(error => error)
    }

    fetchUsers() {
        fetch(USER_API_URL)
            .then(response => response.json())
            .then(result =>
                this.setState({
                    users: result.data,
                    filteredAccounts: result.data
                })
            )
            .catch(error => error)
    }

    fetchUser(uid) {
        fetch(USER_API_URL + uid)
            .then(response => response.json())
            .then(result =>
                this.setState({
                    selectedUser: result.data,
                    userIsLoading: false
                })
            )
            .catch(error => error)
    }

    componentDidMount() {
        this.fetchAuthUser();
        this.fetchUsers();
    }

    userHasPermission(permission) {
        let match = false;
        for (let i = 0; i < this.state.permissions.length; i++) {
            if (this.state.permissions[i].name === permission) {
                match = true;
            }
        }
        return match;
    }

    handleChange(event) {
        const { value } = event.target;
        this.setState({ value });
    };

    renderUser(event) {
        let elm = $(event.target);
        let uid = elm.data('uid');
        elm.parent().find('div').each(function() {
           $(this).removeClass('selected');
        });
        elm.addClass('selected');
        this.setState({
            userIsLoading: true
        });
        this.fetchUser(uid);
    }

    handleSelectedUser() {
        if (this.state.userIsLoading) {
            return (
                <StandardLoadingComponent/>
            )
        } else {
            if (this.state.selectedUser.length < 1) {
                return (
                    <div className="no-user-selected">
                        Select a user
                    </div>
                )
            }
            let user = this.state.selectedUser[0];
            if (user.phone === null) {
                user.phone = 'Not available';
            }
            if (user.user_type_name === null) {
                user.user_type_name = 'not set';
            }
            return (
                <div className={"mt-3"}>
                    <div className="row">
                        <div className="col-md-6 col-sm-6">
                            <h4>{user.name}</h4>
                            <div>
                                Image
                            </div>
                            <div className="form-group">
                                <label htmlFor="account-name" className="form-label">Name</label>
                                <span className={'d-block'}>{user.name}</span>
                            </div>
                            <div className="form-group">
                                <label htmlFor="account-email" className="form-label">Email</label>
                                <span className={'d-block'}>{user.email}</span>
                            </div>
                            <div className="form-group">
                                <label htmlFor="account-phone" className="form-label">Phone</label>
                                <span className={'d-block'}>{user.phone}</span>
                            </div>
                            <div className="form-group">
                                <label htmlFor="account-type" className="form-label">Type</label>
                                <span className={'d-block'}>{user.user_type_name.toProperCase()}</span>
                            </div>
                        </div>
                    </div>
                </div>
            )
        }
    }

    render() {
        const { users, value } = this.state;
        return (
            <div>
                <h4 className="d-flex justify-content-between align-items-center w-100 font-weight-bold py-3 mb-4">
                    <div>Accounts</div>
                    <button type="button" className="btn d-block btn-primary rounded-pill waves-effect"
                            data-toggle="modal" data-target="#create-user-account">
                        <span className="ion ion-md-add"></span>&nbsp; Add user</button>
                </h4>
                <div className="row">
                    <div className="col-sm-6 col-md-4">
                        <div className="form-group">
                            <label htmlFor="filter-accounts" className="form-label">Search</label>
                            <input className={"form-control"} type="search" id={"filter-accounts"}
                                   name={"filter-accounts"} placeholder={'Enter a name...'}
                                   value={value}
                                   onChange={this.handleChange.bind(this)}/>
                        </div>
                        <div className="account-list">
                            <SearchResults
                                value={value}
                                data={users}
                                renderResults = { results => (
                                    <div>
                                        {results.map((user, index) => {
                                            return (
                                                <div data-uid={user.uid} className="account-list-item d-flex"
                                                     onClick={this.renderUser.bind(this)} key={index}>
                                                    <div className="account-img-container">
                                                        <div className="account-img">
                                                            <img src={"assets/img/avatars/6-small.png"}
                                                            className="d-block ui-w-40 rounded-circle"/>
                                                        </div>
                                                    </div>
                                                    <div className="account-info">
                                                        <div className="account-info-name">{user.name}</div>
                                                        <div className={"account-info-sid"}>@{user.sid}</div>
                                                    </div>
                                                </div>
                                            )
                                        })}
                                    </div>
                                )}
                                />
                        </div>
                    </div>
                    <div className="col-sm-6 col-md-8">

                        {this.handleSelectedUser()}

                    </div>
                </div>
            </div>
        )
    }
}


if (document.getElementById('user-accounts-wrapper')) {
    ReactDOM.render(<AccountMain />, document.getElementById('user-accounts-wrapper'));
}