import React, { Component } from 'react';
import StandardLoadingComponent from "../loading/StandardLoadingComponent";
import PermissionsFromNameCardItems from "./PermissionsFromNameCardItems";

const PERMISSIONS_SERVICE_URL = '/api/v1/roles/';

export default class PermissionsFromRoleNameCards extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            category: this.props.category,
            roleName: this.props.roleName,
            permissionsFromRoleNameByCategory: this.props.permissionsFromRoleNameByCategory,
        }
    }

    componentDidMount() {
        this.setState({
            isLoaded: true
        })
    }

    render() {
        if (this.state.isLoaded) {
            const category = this.state.category.split(' ').join('_');
            return (
                <div className="card mb-2">
                    <h4 className="card-header">{this.state.category.toProperCase()}</h4>
                    <div className="card-body">
                        <div className="card-text">
                            {this.state.permissionsFromRoleNameByCategory.map((permissions, index) => {
                                if (permissions.hasOwnProperty(category)) {
                                    return (
                                        <PermissionsFromNameCardItems
                                            permissions={permissions}
                                            category={category}
                                            key={index}
                                        />
                                    )
                                }
                            })}
                        </div>
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