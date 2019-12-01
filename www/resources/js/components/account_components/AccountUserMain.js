import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import EditText from 'react-editext';

import StandardLoadingComponent from "../loading/StandardLoadingComponent";
import AccountUserActivity from "./AccountUserActivity";

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

    componentWillMount() {
        this.fetchAuthUser();
        this.fetchUser(uid);

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
                <StandardLoadingComponent/>
            )
        } else {
            const user = this.state.user;
            return (
                <div className={"row"}>
                    <div className="card col-md-4 col-sm-12 account-right">
                        <div className="card-body">
                            <a href="/accounts"><i className="lnr lnr-arrow-left"></i> &nbsp; Accounts</a>
                            <div className="media mt-2">
                                <img className={"m-auto text-center"} src={user.avatar_url} alt=""
                                     style={{height: '100px', borderRadius: '100%'}}/>
                            </div>
                            <div className="media-body pt-2 ml-3 text-center">
                                <h3 className="mb-2">{user.name}</h3>
                                <div className="text-muted small">{user.email}</div>

                                <div className="text-muted small mt-2">
                                    {(user.employee) ? 'Employee' : 'Non-employee' +
                                        ((user.user_type_name !== null) ? ' | ' +
                                            user.user_type_name.toProperCase() : null)}
                                </div>

                                <div className="mt-3">
                                    <a href="#" className="btn icon-btn btn-default btn-sm md-btn-flat rounded-pill">
                                        <span className="ion ion-md-mail"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr className="border-light m-0"/>
                        <div className="card-body" style={{maxHeight: '400px', overflow: 'auto'}}>
                            <h5>Recent Activity
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
                        <div className="card-body p-0">
                            <div className="nav-tabs-top">
                                <ul className="nav nav-tabs">
                                    <li className="nav-item">
                                        <a className="nav-link active" data-toggle="tab" href="#navs-top-account">Account</a>
                                    </li>
                                    <li className="nav-item">
                                        <a className="nav-link" data-toggle="tab" href="#navs-top-activity">Activity</a>
                                    </li>
                                    <li className="nav-item">
                                        <a className="nav-link" data-toggle="tab" href="#navs-top-sessions">Sessions</a>
                                    </li>
                                </ul>
                                <div className="tab-content">
                                    <div className="tab-pane fade active show" id="navs-top-account">
                                        <div className="card-body">
                                            <div className="row">
                                                <div className="col-6">
                                                    <div className="section-heading">Profile</div>
                                                    <div className="mb-2">
                                                        <span className="text-muted">SID:</span>&nbsp;
                                                        {user.sid}
                                                    </div>
                                                    <div className="mb-2">
                                                        <span className="text-muted">Name: &nbsp;</span>
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
                                                    <div className="mb-2">
                                                        <span className="text-muted">Email: &nbsp;</span>
                                                        {user.email}
                                                    </div>
                                                    <div className="mb-2">
                                                        <span className="text-muted">Phone: &nbsp;</span>
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
                                                    <div className="mb-2">
                                                        <span className="text-muted">Country:</span>&nbsp;
                                                        {(user.country !== null) ? user.country.toProperCase() : 'N/A'}
                                                    </div>

                                                    <div className="mb-2">
                                                        <span className="text-muted">State:</span>&nbsp;
                                                        {(user.state !== null) ? user.state.toProperCase() : 'N/A'}
                                                    </div>

                                                    <div className="mb-2">
                                                        <span className="text-muted">City:</span>&nbsp;
                                                        {(user.city !== null) ? user.city.toProperCase() : 'N/A'}
                                                    </div>
                                                </div>
                                                <div className="col-6">
                                                    <div className="row">
                                                        <div className="col-12">
                                                            <div className="section-heading">Security</div>
                                                            <div className="mb-2">
                                                                <span className="text-muted">Account:</span>&nbsp;
                                                                {(user.locked) ? 'Disabled' : 'Enabled'}
                                                            </div>
                                                            <div className="mb-2">
                                                                <span className="text-muted">Verified:</span>&nbsp;
                                                                {(user.email_verified_at !== null) ? 'Verified' : 'Not verified'}
                                                            </div>
                                                            <div className="mb-2">
                                                                <span className="text-muted">One Time Password:</span>&nbsp;
                                                                {(user.otp_exemption) ? 'Enabled' : 'Disabled'}
                                                            </div>

                                                            <div className="row mt-2">
                                                                {(user.ldap_user) ?
                                                                    <div className="col-12">
                                                                        <hr className="border-light m-0"/>
                                                                        <div className="section-heading">LDAP</div>
                                                                        <div className="mb-2">
                                                                            <span className="text-muted">CN:</span>&nbsp;
                                                                            {user.meta.ldap.cn}
                                                                        </div>
                                                                        <div className="mb-2">
                                                                            <span className="text-muted">Mail:</span>&nbsp;
                                                                            {user.meta.ldap.mail}
                                                                        </div>
                                                                        <div className="mb-2">
                                                                            <span className="text-muted">GivenName:</span>&nbsp;
                                                                            {user.meta.ldap.givenname}
                                                                        </div>
                                                                        <div className="mb-2">
                                                                            <span className="text-muted">SN:</span>&nbsp;
                                                                            {user.meta.ldap.sn}
                                                                        </div>
                                                                        <div className="mb-2">
                                                                            <span className="text-muted">UID:</span>&nbsp;
                                                                            {user.meta.ldap.uid}
                                                                        </div>
                                                                        <div className="mb-2">
                                                                            <span className="text-muted">DN:</span>&nbsp;
                                                                            {user.meta.ldap.dn}
                                                                        </div>
                                                                    </div>
                                                                    : null }
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div className="tab-pane fade" id="navs-top-activity">
                                        <div className="card-body">
                                            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress,
                                                commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny
                                                pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
                                        </div>
                                    </div>
                                    <div className="tab-pane fade" id="navs-top-sessions">
                                        <div className="card-body">
                                            <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy
                                                salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably
                                                haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                                        </div>
                                    </div>
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