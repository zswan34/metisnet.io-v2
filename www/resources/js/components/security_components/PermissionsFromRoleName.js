import React, { Component } from 'react';
import StandardLoadingComponent from "../loading/StandardLoadingComponent";
import ErrorComponent from "../errors/ErrorComponent";
import PermissionsFromRoleNameCards from "./PermissionsFromRoleNameCards";

const PERMISSIONS_SERVICE_URL = '/api/v1/roles/';

export default class PermissionsFromRoleName extends Component {
    constructor(props) {
        super(props);

        this.state = {
            hasError: false,
            isLoaded: false,
            roleName: this.props.roleName,
            categories: [],
            allPermissionsByCategory: [],
            permissionsFromRoleNameByCategory: []

        }
    }

    fetchPermissionsFromRoleNameByCategory() {
        fetch(PERMISSIONS_SERVICE_URL + this.state.roleName + '/permissions?groupBy=category&filter=compare')
            .then(response => response.json())
            .then(result =>
                this.setState({
                    permissionsFromRoleNameByCategory: result,
                    isLoaded: true

                })
            )
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }


    fetchAllPermissionByCategory() {
        fetch('/api/v1/permissions?groupBy=category')
            .then(response => response.json())
            .then(result =>
                this.setState({
                    allPermissionsByCategory: result,
                    categories:  Object.getOwnPropertyNames(result),
                })
            )
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    componentDidMount() {
        this.fetchAllPermissionByCategory();
        this.fetchPermissionsFromRoleNameByCategory();
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
                            {this.state.categories.map((category, index) => {
                                return (
                                    <PermissionsFromRoleNameCards
                                        category={category}
                                        roleName={this.state.roleName}
                                        permissionsFromRoleNameByCategory={this.state.permissionsFromRoleNameByCategory}
                                        key={index}/>
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