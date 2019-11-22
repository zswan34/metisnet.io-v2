import React, { Component } from 'react';
import axios from 'axios';

const ROLES_DETAILS = '/api/v1/roles/';

export default class DeleteRoleModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            role: this.props.roleName,
            roleDetails: [],
        }
    }

    componentDidMount() {
        this.setState({
            isLoaded: true
        })
    }

    deleteRole(event) {
        event.preventDefault();
        let roleName = this.state.role.name.replaceChar(' ', '-');
        let modal = $('#delete-role-modal-' + roleName);
        axios.delete($(event.target).attr('action'))
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
            $("#delete-role-button-" + this.state.role.name.replaceChar(' ', '-')).show();

            return (
                <div className="modal fade" id={"delete-role-modal-" + this.state.role.name.replaceChar(' ', '-')} tabIndex="-1" role="dialog"
                     aria-labelledby="edit-role-modal" aria-hidden="true">
                    <div className="modal-dialog" role="document">
                        <div className="modal-content">
                            <form onSubmit={this.deleteRole.bind(this)} action={"/api/v1/roles/" +
                            this.state.role.name.replaceChar(' ', '-') + "/edit"} method={"post"}
                                  autoComplete={"off"}>
                                <div className="modal-header">
                                    <h5 className="modal-title">Delete {this.state.role.name.toProperCase()} Role</h5>
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    <div className="form-group">
                                        <label className={"form-label"} htmlFor="delete-role-name">Name</label>
                                        <input className={"form-control"} type={'text'} id={"delete-role-name"} name={"delete-role-name"} />
                                    </div>

                                </div>
                                <div className="modal-footer mt-3">
                                    <button type="submit" className="btn btn-danger w-100">Delete Role Role</button>
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