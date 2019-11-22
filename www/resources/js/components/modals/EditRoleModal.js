import React, { Component } from 'react';
import EditRoleModalItems from "./EditRoleModalItems";

const ROLES_DETAILS = '/api/v1/roles/';

export default class EditRoleModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            role: this.props.roleName,
            roleDetails: [],
            categories: [],
            permissionsFromRoleNameByCategory: [],
            allPermissionsByCategory: this.props.allPermissionsByCategory,
        }
    }

    fetchPermissionsFromRoleNameByCategory() {
        fetch(ROLES_DETAILS + this.state.role.name + '/permissions?groupBy=category&filter=compare')
            .then(response => response.json())
            .then(result =>
                this.setState({
                    permissionsFromRoleNameByCategory: result,
                    isLoaded: true

                })
            )
            .catch(error => this.setState({error, isLoaded: false, hasError: true}));
    }

    componentDidMount() {
        this.setState({
            categories: Object.getOwnPropertyNames(this.state.allPermissionsByCategory)
        });
        this.fetchPermissionsFromRoleNameByCategory();
    }

    editRole(event) {
        event.preventDefault();
        let roleName = this.state.role.name.replaceChar(' ', '-');
        let modal = $('#edit-role-modal-' + roleName);
        axios.post($(event.target).attr('action'), $(event.target).serialize())
            .then((res) => {
                if (res.data.success) {
                    modal.modal('hide');
                    modal.find('form')[0].reset();
                    window.location.href = '/roles-and-permissions'
                }
            })
    }

    render() {
        if (this.state.isLoaded) {
            $("#edit-role-button-" + this.state.role.name.replaceChar(' ', '-')).show();
            $("#delete-role-button-" + this.state.role.name.replaceChar(' ', '-')).show();

            return (
                <div className="modal fade" id={"edit-role-modal-" + this.state.role.name.replaceChar(' ', '-')} tabIndex="-1" role="dialog"
                     aria-labelledby="edit-role-modal" aria-hidden="true">
                    <div className="modal-dialog edit-modal-dialog" role="document">
                        <div className="modal-content">
                            <form onSubmit={this.editRole.bind(this)} action={"/api/v1/roles/" +
                            this.state.role.name.replaceChar(' ', '-') + "/edit"} method={"post"}
                                  autoComplete={"off"}>
                                <div className="modal-header">
                                    <h5 className="modal-title">Edit {this.state.role.name.toProperCase()} Role</h5>
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div className="modal-body edit-modal-body">
                                    <input type="hidden" defaultValue={this.state.role.name} name={'edit-role-name'}/>
                                    <div className="form-group">
                                        <label className={"form-label"} htmlFor="edit-role-desc">Description</label>
                                        <textarea className={"form-control"} id={"edit-role-desc"}
                                                  name={"edit-role-desc"}
                                                  style={{resize: 'none'}} rows={"7"} defaultValue={this.state.role.description}>
                                    </textarea>
                                    </div>
                                        {this.state.categories.map((category, index) => {
                                            return (
                                                <div className={"row mx-1"} key={index}>
                                                    <div className="form-group w-100">
                                                        <h5>{category.toProperCase()}</h5>
                                                        {this.state.permissionsFromRoleNameByCategory.map((permissions, index) => {
                                                            if (permissions.hasOwnProperty(category.split(' ').join('_'))) {
                                                                return (
                                                                    <EditRoleModalItems
                                                                        category={category}
                                                                        permissions={permissions}
                                                                        key={index}/>
                                                                )
                                                            }
                                                        })}
                                                    </div>
                                                </div>

                                            )
                                        })}

                                </div>
                                <div className="modal-footer mt-3">
                                    <button type="button" className="btn btn-secondary" data-dismiss="modal">Close
                                    </button>
                                    <button type="submit" className="btn btn-primary">Update Role</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )
        } else {
            return (
                <div></div>
            )
        }
    }
}