import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ReactTooltip from 'react-tooltip'
import EditText from 'react-editext';

import AccountUserActivity from "./AccountUserActivity";
import EclipseLoadingComponent from "../loading/EclipseLoadingComponent";


const uid = window.location.pathname.split('/')[2];
const AUTH_USER_URL = '/api/v1/auth/';
const UPDATE_USER_API = '/api/v1/users/';
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

    componentDidMount() {
        this.fetchAuthUser();
        this.fetchUser(uid);
        $('[data-toggle="tooltip"]').tooltip()
    }
    updateUser(data) {
        axios.post(UPDATE_USER_API + this.state.user.uid, data)
            .then((res) => {
                if (res.data.success) {
                    this.fetchUser(uid);
                }
            })
    }

    onSaveInput(event, field) {
        let data = {
            field: event,
            value: field
        };
        this.updateUser(data);
    }

    render() {
        if (!this.state.isLoaded) {
            return (
                <EclipseLoadingComponent/>
            )
        } else {
            const user = this.state.user;
            let userType = (user.user_type_name !== null) ? user.user_type_name.toProperCase() : null;
            return (
                <div className={"row"}>
                    <ReactTooltip />
                    <div className="card col-md-4 col-sm-12 account-right">
                        <div className="card-body">
                            <a href="/accounts"><i className="lnr lnr-arrow-left"></i> &nbsp; Accounts</a>
                            <div className="media mt-2">
                                <img className={"m-auto text-center"} src={user.avatar_url} alt=""
                                     style={{height: '80px', borderRadius: '100%'}}/>
                            </div>
                            <div className="media-body pt-2 ml-3 text-center">
                                <h4 className="mb-1">{user.name}</h4>
                                <div className="text-muted small">
                                    {(user.employee) ? 'Employee' : 'Non-employee | ' + userType}
                                </div>

                                <div className="mt-1">
                                    <span className="btn icon-btn btn-primary btn-sm md-btn-flat border border-primary user-action-btn"
                                          data-tip={"Send mesage"}>
                                        <span className="ion ion-md-mail"></span>
                                    </span>
                                    {user.locked ?
                                        <span className="btn icon-btn btn-primary btn-sm md-btn-flat border border-primary user-action-btn"
                                              data-tip={"Unlock account"}>
                                            <span className="ion ion-md-lock"></span>
                                        </span>
                                        :
                                        <span className="btn icon-btn btn-primary btn-sm md-btn-flat border border-primary user-action-btn"
                                              data-tip={"Lock account"}>
                                            <span className="ion ion-md-unlock"></span>
                                        </span>
                                    }
                                </div>
                            </div>
                        </div>
                        <hr className="border-light m-0"/>
                        <div className="card-body" style={{maxHeight: '400px', overflow: 'auto'}}>
                            <h5 className={"mb-4"}>Recent Activity
                                <small className={'ml-2'}>
                                    <a href={"/accounts/" + user.uid + '/activity'}>See more</a>
                                </small>
                            </h5>
                            <AccountUserActivity
                                authUser={this.state.authUser}
                                user={this.state.user}
                                />
                        </div>
                    </div>
                    <div className="card col-md-8 col-sm-12 account-left p-0">
                        <h4 className={"card-header"}>Profile</h4>
                        <div className="card-body">
                            <div className="row">
                                <div className="col-md-6 col-sm-12">

                                    <h5 className={"mb-0 text-primary"}>General Information</h5>
                                    <hr className={'bg-primary'}/>
                                    <div className="form-group">
                                        <label className="form-label italics">SID</label>
                                        <span className={"d-block"}>{user.sid}</span>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label italics">Name</label>
                                        {(this.userHasPermission('edit users')) ?
                                            <EditText
                                                type='text'
                                                mainContainerClassName={"react-editext-main"}
                                                saveButtonContent={<i className={'lnr lnr-checkmark-circle text-success'}></i>}
                                                cancelButtonContent={<i className={'lnr lnr-cross-circle text-danger'}></i>}
                                                editButtonContent={<span className={'text-primary'}>edit</span>}
                                                hideIcons={true}
                                                onSave={this.onSaveInput.bind(this, 'name')}
                                                value={(user.name === null) ? 'Not set' : user.name}
                                            />
                                            :  (user.name === null) ? 'Not set' : user.name}
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label italics">Email</label>
                                        <span className={"d-block"}>{user.email}</span>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label italics">Phone</label>
                                        {(this.userHasPermission('edit users')) ?
                                            <EditText
                                                type='tel'
                                                mainContainerClassName={"react-editext-main"}
                                                saveButtonContent={<i className={'lnr lnr-checkmark-circle text-success'}></i>}
                                                cancelButtonContent={<i className={'lnr lnr-cross-circle text-danger'}></i>}
                                                editButtonContent={<span className={'text-primary'}>edit</span>}
                                                hideIcons={true}
                                                onSave={this.onSaveInput.bind(this, 'phone')}
                                                value={(user.phone === null) ? 'Not set' : user.phone}
                                            />
                                            : (user.phone === null) ? 'Not set' : user.phone}
                                    </div>
                                    <div className="form-group">
                                    <label className="form-label italics">Country</label>
                                        <span className={"d-block"}> {(user.country !== null) ? user.country.toProperCase() : 'N/A'}</span>
                                </div>
                                    <div className="form-group">
                                        <label className="form-label italics">State</label>&nbsp;
                                        <span className={"d-block"}> {(user.state !== null) ? user.state.toProperCase() : 'N/A'}</span>
                                    </div>
                                    <div className="form-group">
                                        <label className="form-label italics">City</label>
                                        <span className={"d-block"}> {(user.city !== null) ? user.city.toProperCase() : 'N/A'}</span>
                                    </div>

                                </div>
                                <div className="col-md-6 col-sm-12">
                                    <h5 className={"mb-0 text-primary"}>Account</h5>
                                    <hr className={'bg-primary'}/>
                                    <div className="form-group">
                                        <label className={"form-label italics"}>Account Locked</label>
                                        <span className={"d-block"}> {(user.locked) ? 'True' : 'False'}</span>
                                    </div>
                                    <div className="form-group">
                                        <label className={"form-label italics"}>Account Verified</label>
                                        <span className={"d-block"}> {(user.email_verified_at !== null) ? 'True' : 'False'}</span>
                                    </div>
                                    {(user.ldap_user) ?
                                    <div className={"mt-4 mb-3"}>
                                        <h6 className={"mb-0 text-primary"}>LDAP</h6>
                                        <hr className={'bg-primary'}/>
                                        <div className="form-group">
                                            <label className="form-label italics">CN</label>
                                            <span className={"d-block"}>{user.meta.ldap.cn}</span>
                                        </div>
                                        <div className="form-group">
                                            <label className="form-label italics">Email</label>
                                            <span className={"d-block"}>{user.meta.ldap.mail}</span>
                                        </div>

                                        <div className="form-group">
                                            <label className="form-label italics">GivenName:</label>
                                            <span className={"d-block"}>{user.meta.ldap.givenname}</span>
                                        </div>
                                        <div className="form-group">
                                            <label className="form-label italics">SN:</label>
                                            <span className={"d-block"}>{user.meta.ldap.sn}</span>
                                        </div>
                                        <div className="form-group">
                                            <label className="form-label italics">UID:</label>
                                            <span className={"d-block"}>{user.meta.ldap.uid}</span>
                                        </div>
                                        <div className="form-group">
                                            <label className="form-label italics">DN:</label>
                                            <span className={"d-block"}>{user.meta.ldap.dn}</span>
                                        </div>
                                    </div>
                                    : null }
                                </div>
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