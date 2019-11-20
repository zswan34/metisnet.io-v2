import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import PermissionsFromRoleName from "./PermissionsFromRoleName";
import CreateRoleModal from "../modals/CreateRoleModal";
import StandardLoadingComponent from "../loading/StandardLoadingComponent";

const FETCH_ROLES_URL = '/api/v1/roles';

export default class RolesAndPermissions extends Component {
    constructor(props) {
        super(props);
        this.state = {
            roles: [],
            isLoaded: false,
            componentIsLoaded: false,
            allPermissionsByCategory: [],
        }
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
        this.allPermissionsByCategory();
        this.fetchRoles();
    }

    render() {
        if (this.state.isLoaded) {
            return (
                <div>
                    <h4 className="font-weight-bold py-3 mb-1">
                        Roles & Permissions
                    </h4>

                    <button className={"btn btn-outline-primary mb-3"} data-toggle="modal"
                            data-target="#create-role-modal">
                        Create Role
                    </button>

                    <div className="row">
                        <div className="col-3">
                            <div className="list-group bg-white">
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
                        <div className="col-9">
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
                                                <h5>Description</h5>
                                                <hr className={"bg-light"}/>
                                                {role.description}
                                                <h5 className={"mt-5"}>Permissions</h5>
                                                <hr className="bg-light"/>
                                                <PermissionsFromRoleName
                                                    roleName={role.name}/>
                                            </div>
                                        )
                                    }
                                })}
                            </div>
                        </div>
                    </div>
                    <CreateRoleModal allPermissionsByCategory={this.state.allPermissionsByCategory}/>
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
