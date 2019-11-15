import React, { Component } from 'react';

export default class EditDomainsAccountsModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            domain: []
        }
    }

    componentDidMount() {
        this.setState({
            domain: this.props.domain,
            callback: this.props.callback
        })
    }

    editAccount(event) {
        event.preventDefault();
        const elm = $(event.target);
        const data = $(event.target).serialize();
        axios.post('/api/v1' + $(event.target).attr('action'), data)
            .then((res) => {
                if (res.data.success) {
                    elm.parent().parent().modal('hide');
                    this.props.updateDomains();
                }
            }).catch((err) => {
                //
        });
    };

    render() {
        return (
            <div>
                <div className="modal fade" id={"edit-domain-account-modal-" + this.props.domain.uid} tabIndex="-1" role="dialog"
                     aria-labelledby="edit-exampleModalLabel" aria-hidden="true">
                    <div className="modal-dialog" role="document">
                        <form data-uid={this.props.domain.uid} id={"edit-domain-account-form" + this.props.domain.uid}
                              action={"/domains/" + this.props.domain.uid + "/edit"} method="post"
                              onSubmit={this.editAccount.bind(this)}>
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h5 className="modal-title" id="edit-exampleModalLabel">Edit this account</h5>
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    <div className="form-group">
                                        <label htmlFor="edit-account-nickname">Name</label>
                                        <input className="form-control" type="text" id="edit-account-nickname"
                                               name="edit-account-nickname" placeholder="Name"
                                        defaultValue={`${this.props.domain.nickname}`}/>
                                    </div>
                                    <div className="form-group">
                                        <label htmlFor="edit-account-type" className="form-label">Type</label>
                                        <input className={"form-control"} disabled name={"edit-account-type"} value={"Godaddy"}/>
                                    </div>
                                    <div id="edit-godaddy-options">
                                        <div className="form-group">
                                            <label htmlFor="edit-godaddy-account-api-key" className="form-label">Api Key</label>
                                            <input type="text" id="edit-godaddy-account-api-key"
                                                   name="edit-godaddy-account-api-key" className="form-control"
                                                   placeholder="Api Key" defaultValue={`${this.props.domain.api_key}`}/>
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="edit-godaddy-account-api-secret" className="form-label">Api
                                                Secret</label>
                                            <input type="text" id="edit-godaddy-account-api-secret"
                                                   name="edit-godaddy-account-api-secret" className="form-control"
                                                   placeholder="Api Secret" defaultValue={`${this.props.domain.api_secret}`}/>
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
            </div>
        )
    }
}