import React, { Component } from 'react';
import StandardLoadingComponent from "../loading/StandardLoadingComponent";
import ErrorComponent from "../errors/ErrorComponent";

const PERMISSIONS_SERVICE_URL = '/api/v1/roles/';

export default class PermissionsFromRoleNameCard extends Component {

    constructor(props) {
        super(props);

        this.state = {
            roleName: this.props.roleName,
            permissionsFromRole: [],
            permissions: [],
            hasError: false,
            isLoaded: false
        }
    }

    fetchPermissions() {
        fetch(PERMISSIONS_SERVICE_URL + this.state.roleName + '/permissions')
            .then(response => response.json())
            .then(result =>
                this.setState({
                    permissionsFromRole: result,
                    isLoaded: true
                })
            )
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    componentDidMount() {
        this.fetchPermissions();
    }

    render() {
        if (this.state.hasError) {
            return (
                <ErrorComponent/>
            )
        } else {
            if (this.state.isLoaded) {
                return (
                    <div className={"row"}>
                        <div className={"w-100"}>
                            {this.state.permissions.map((permission, index) => {
                                return (
                                    <div className="col-lg-4 col-md-6" key={index}>
                                        <div className="card mb-4">
                                            <div className="card-body">
                                                {permission.name.toProperCase()}
                                            </div>
                                        </div>
                                    </div>
                                )
                            })}
                        </div>
                    </div>
                )
            } else {
                return (
                    <StandardLoadingComponent/>
                )
            }
        }
    }

}
