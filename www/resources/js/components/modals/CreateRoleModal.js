import React, { Component } from 'react';

export default class CreateRoleModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            isLoaded: false,
            categories: [],
            allPermissionsByCategory: this.props.allPermissionsByCategory,
        }
    }

    componentDidMount() {
        this.setState({
            isLoaded: true,
            categories:  Object.getOwnPropertyNames(this.state.allPermissionsByCategory)
        });
        $('[data-toggle="tooltip"]').tooltip({
            delay: {
                "show": 2000,
                "hide": 100
            }
        })
    }

    createNewRole(event) {
        event.preventDefault();
        console.log($(event.target).serialize());
    }

    render() {
        if (this.state.isLoaded) {
            return (
                <div className="modal fade" id="create-role-modal" tabIndex="-1" role="dialog"
                     aria-labelledby="create-role-modal" aria-hidden="true">
                    <div className="modal-dialog" role="document">
                        <div className="modal-content">
                            <form onSubmit={this.createNewRole.bind(this)} action={"/api/v1/roles/create"} method={"post"}>
                                <div className="modal-header">
                                    <h5 className="modal-title" id="create-role-modal">Create Role</h5>
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    <div className="form-group">
                                        <label className={"form-label"} htmlFor="role-name">Name</label>
                                        <input className={"form-control"} type="text" id={"role-name"}
                                               name={"role-name"}/>
                                    </div>

                                    <div className="form-group">
                                        <label className={"form-label"} htmlFor="role-desc">Description</label>
                                        <textarea className={"form-control"} type="text" id={"role-desc"}
                                                  name={"role-desc"}
                                                  style={{resize: 'none'}} rows={"3"}>
                                    </textarea>
                                    </div>
                                    <div className="form-group">
                                        {this.state.categories.map((category, index) => {
                                            return (
                                                <div key={index}>
                                                    <h5>{category.toProperCase()}</h5>
                                                    <div className="row mb-3">
                                                        {this.state.allPermissionsByCategory[category].map((permission, index) => {
                                                            let name = permission.name.split(' ').join('-');
                                                            return (
                                                                <div className={"col-6"} key={index}>
                                                                    <label className="custom-control custom-checkbox">
                                                                        <input type="checkbox" className="custom-control-input" name={"role-" + name}/>
                                                                            <span className="custom-control-label" style={{fontSize: '.8rem'}}>
                                                                                {permission.name.toProperCase()}
                                                                            </span>
                                                                    </label>
                                                                </div>
                                                            )
                                                        })}
                                                        </div>
                                                </div>
                                            )
                                        })}
                                    </div>
                                </div>
                                <div className="modal-footer">
                                    <button type="button" className="btn btn-secondary" data-dismiss="modal">Close
                                    </button>
                                    <button type="submit" className="btn btn-primary">Create Role</button>
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