import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PermissionsFromRoleName from "./PermissionsFromRoleName";
import CreateRoleModal from "../modals/CreateRoleModal";
import StandardLoadingComponent from "../loading/StandardLoadingComponent";
import EditRoleModal from "../modals/EditRoleModal";
import DeleteRoleModal from "../modals/DeleteRoleModal";

const FETCH_ROLES_URL = '/api/v1/roles';
const AUTH_USER_URL = '/api/v1/auth/';

export default class RolesAndPermissions extends Component {
    constructor(props) {
        super(props);
        this.state = {
            roles: [],
            authUser: [],
            permissions: [],
            isLoaded: false,
            componentIsLoaded: false,
            allPermissionsByCategory: [],
        };
        this.permissionFromRole = React.createRef();
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

    userHasPermission(permission) {
        let match = false;
        for (let i = 0; i < this.state.permissions.length; i++) {
            if (this.state.permissions[i].name === permission) {
                match = true;
            }
        }
        return match;
    }

    allPermissionsByCategory() {
        fetch('/api/v1/permissions?groupBy=category')
            .then(response => response.json())
            .then(result =>
                this.setState({
                    allPermissionsByCategory: result,
                    componentIsLoaded: true
                })
            )
            .catch(error => this.setState({error, componentIsLoaded: false, hasError: true}));
    }

    fetchRoles() {
        fetch(FETCH_ROLES_URL)
            .then(response => response.json())
                .then(result =>
                    this.setState({
                        roles: result,
                        isLoaded: true
                    })
                )
                .catch(error => this.setState({error, isLoaded: false, hasError: true}
            )
        );
    }

    componentDidMount() {
        this.fetchAuthUser();
        this.allPermissionsByCategory();
        this.fetchRoles();
    }

    updateComponents() {
        this.allPermissionsByCategory();
        this.fetchRoles();
    }

    displayEditButton(role) {
        if (this.userHasPermission('edit roles')) {
            return (
                <button id={"edit-role-button-" +role} style={{display: 'none'}} type={'button'}
                        className={"btn btn-warning btn-sm pull-right"}
                data-toggle="modal" data-target={"#edit-role-modal-" + role}>
                    <i className="lnr lnr-pencil"></i> &nbsp;
                    Edit
                </button>
            )
        }
    }

    displayDeleteButton(role) {
        if (this.userHasPermission('delete roles')) {
            return (
                <button id={"delete-role-button-" +role} style={{display: 'none'}}
                        type={'button'} className={"btn btn-outline-danger btn-sm pull-right mx-2"}
                    data-toggle="modal" data-target={"#delete-role-modal-" + role}>
                    <i className="lnr lnr-trash"></i> &nbsp;
                    Delete
                </button>
            )
        }
    }

    render() {
        if (this.state.isLoaded) {
            return (
                <div>
                    <h4 className="font-weight-bold py-3 mb-1">
                        Roles & Permissions
                    </h4>
                    {this.userHasPermission('add roles') ?
                        <button className={"btn btn-outline-primary mb-3"} data-toggle="modal"
                                data-target="#create-role-modal">
                            Create Role
                        </button> : null
                    }
                    <div className="row">
                        <div className="col-md-3 col-sm-12">
                            <div className="list-group bg-white mb-4">
                                {this.state.roles.map((role, index) => {
                                    let active = 'active';
                                    if (index !== 0) {
                                        active = '';
                                    }
                                    let name = role.name.split(' ').join('-');
                                    return (
                                        <a className={"list-group-item list-group-item-action " + active}
                                           id={"role-tab-" + name}
                                           data-toggle="list" href={"#role-" + name}
                                           key={index}>{`${role.name.toUpperCase()}`}</a>
                                    )
                                })}
                            </div>
                        </div>
                        <div className="col-md-9 col-sm-12">
                            <div className="tab-content">
                                {this.state.roles.map((role, index) => {
                                    let active = 'active show';
                                    if (index !== 0) {
                                        active = '';
                                    }
                                    let name = role.name.split(' ').join('-');
                                    if (this.state.componentIsLoaded) {
                                        return (
                                            <div className={"tab-pane fade " + active} id={"role-" + name} key={index}>
                                                <h5>Description
                                                    {this.displayDeleteButton(name)}
                                                    {this.displayEditButton(name)}
                                                </h5>

                                                <hr className={"bg-light"}/>
                                                {role.description}
                                                <h5 className={"mt-5"}>Permissions</h5>
                                                <hr className="bg-light"/>

                                                <PermissionsFromRoleName
                                                    updateComponents={this.updateComponents.bind(this)}
                                                    allPermissionsByCategory={this.state.allPermissionsByCategory}
                                                    role={role}
                                                    roleName={role.name}/>

                                                <EditRoleModal
                                                    allPermissionsByCategory={this.state.allPermissionsByCategory}
                                                    roleName={role}/>

                                                <DeleteRoleModal
                                                    allPermissionsByCategory={this.state.allPermissionsByCategory}
                                                    roleName={role}/>
                                            </div>
                                        )
                                    }
                                })}
                            </div>
                        </div>
                    </div>
                    <CreateRoleModal
                        updateComponents={this.updateComponents.bind(this)}
                        allPermissionsByCategory={this.state.allPermissionsByCategory}/>
                </div>
            )
        } else {
            return (
                <StandardLoadingComponent/>
            )
        }
    }
}

if (document.getElementById('roles-and-permissions-wrapper')) {
    ReactDOM.render(<RolesAndPermissions />, document.getElementById('roles-and-permissions-wrapper'));
}
