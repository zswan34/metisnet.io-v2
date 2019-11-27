import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import StandardLoadingComponent from "../loading/StandardLoadingComponent";

const uid = window.location.pathname.split('/')[2];
const AUTH_USER_URL = '/api/v1/auth/';
const USER_API_URL = '/api/v1/users/';
export class AccountUserMain extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            hasErrors: false,
            authUser: [],
            permissions: [],
            user: []
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

    fetchUser(uid) {
        fetch(USER_API_URL + uid)
            .then(response => response.json())
            .then(result =>
                this.setState({
                    user: result.data[0],
                    isLoaded: true
                })
            )
            .catch(error => error)
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

    componentWillMount() {
        this.fetchAuthUser();
        this.fetchUser(uid);
    }

    render() {
        if (!this.state.isLoaded) {
            return (
                <StandardLoadingComponent/>
            )
        } else {
            const user = this.state.user;
            console.log(user);
            return (
                <div className="card mb-4">
                    <div className="card-body">
                        <div className="media">
                            <img src={user.avatar_url} alt="" style={{height: '80px'}}/>
                                <div className="media-body pt-2 ml-3">
                                    <h5 className="mb-2">{user.name}</h5>
                                    <div className="text-muted small">{user.email}</div>

                                    <div className="mt-2">
                                        <a href="#" className="text-twitter">
                                            <span className="ion ion-logo-twitter"></span>
                                        </a>
                                        &nbsp;&nbsp;
                                        <a href="#" className="text-facebook">
                                            <span className="ion ion-logo-facebook"></span>
                                        </a>
                                        &nbsp;&nbsp;
                                        <a href="#" className="text-instagram">
                                            <span className="ion ion-logo-instagram"></span>
                                        </a>
                                    </div>

                                    <div className="mt-3">
                                        <a href="#" className="btn btn-primary btn-sm rounded-pill">+&nbsp; Follow</a>
                                        &nbsp;
                                        <a href="#" className="btn icon-btn btn-default btn-sm md-btn-flat rounded-pill">
                                            <span className="ion ion-md-mail"></span>
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <hr className="border-light m-0"/>
                        <div className="card-body">
                            <div className="row">
                                <div className="col-6">
                                    <h5 className={"text-center"}>Information</h5>
                                    <div className="mb-2">
                                        <span className="text-muted">Phone:</span>&nbsp;
                                        {(user.phone === null) ? 'Not set' : user.phone }
                                    </div>
                                    <div className="mb-2">
                                        <span className="text-muted">Phone Secondary:</span>&nbsp;
                                        {(user.phone_secondary === null) ? 'Not set' : user.phone_secondary }
                                    </div>
                                    <div className="mb-2">
                                        <span className="text-muted">Recover Email:</span>&nbsp;
                                        {user.recovery_email}
                                    </div>
                                    <div className="mb-2">
                                        <span className="text-muted">LDAP:</span>&nbsp;
                                        {user.ldap_user}
                                    </div>
                                    <div className="mb-2">
                                        <span className="text-muted">Disadvantage:</span>&nbsp;
                                        {user.disadvantaged}
                                    </div>
                                    <div className="mb-2">
                                        <span className="text-muted">PKI:</span>&nbsp;
                                        {(user.pkcs12 !== null) ? 'Yes' : 'No'}
                                    </div>
                                    <div className="mb-4">
                                        <span className="text-muted">Phone:</span>&nbsp;
                                        +0 (123) 456 7891
                                    </div>
                                    <div className="text-muted">
                                        Lorem ipsum dolor sit amet, nibh suavitate qualisque ut nam. Ad harum primis electram duo, porro principes ei has.
                                    </div>
                                </div>
                                <div className="col-6">
                                    <h5 className="text-center">Sessions</h5>
                                </div>
                        </div>
                        </div>
                </div>
            )
        }
    }
}

if (document.getElementById('user-account-wrapper')) {
    ReactDOM.render(<AccountUserMain />, document.getElementById('user-account-wrapper'));
}