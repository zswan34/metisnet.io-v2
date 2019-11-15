import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class EditDomainsAccountsModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            domain: this.props.domain
        }
    }

    render() {
        return (
            <div className="modal fade" id="edit-domain-account-modal" tabIndex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div className="modal-dialog" role="document">
                    <form id="create-account-form" action="/domains/" method="post">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="exampleModalLabel">Add an account</h5>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <div className="form-group">
                                    <label htmlFor="account-nickname">Nickname</label>
                                    <input className="form-control" type="text" id="account-nickname"
                                           name="account-nickname" placeholder="Nickname"/>
                                </div>
                                <div className="form-group">
                                    <label htmlFor="account-type" className="form-label">Type</label>
                                    <select name="domain-account-type" id="account-type" className="select2">
                                        <option value="godaddy">Godaddy</option>
                                        <option value="google">Google Domains</option>
                                    </select>
                                </div>
                                <div id="godaddy-options">
                                    <div className="form-group">
                                        <label htmlFor="godaddy-account-api-key" className="form-label">Api Key</label>
                                        <input type="text" id="godaddy-account-api-key"
                                               name="godaddy-account-api-key" className="form-control"
                                               placeholder="Api Key"/>
                                    </div>
                                    <div className="form-group">
                                        <label htmlFor="godaddy-account-api-secret" className="form-label">Api
                                            Secret</label>
                                        <input type="text" id="godaddy-account-api-secret"
                                               name="godaddy-account-api-secret" className="form-control"
                                               placeholder="Api Secret"/>
                                    </div>
                                </div>

                                <div id="google-options" style="display: none;">
                                    <p>In progress</p>
                                    <div className="form-group">
                                        <label htmlFor="account-api-key" className="form-label">Api Key</label>
                                        <input type="text" id="account-api-key" name="account-api-key"
                                               className="form-control" placeholder="Api Key"/>
                                    </div>

                                </div>
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="btn btn-secondary"
                                        data-dismiss="modal">Cancel
                                </button>
                                <button type="submit"
                                        className="btn btn-primary">Save changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        )
    }
}