import React, { Component } from 'react';
import axios from 'axios';

export default class DeleteDomainsAccountsModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            domain: [],
            disabled: true
        }
    }

    componentDidMount() {
        this.setState({
            domain: this.props.domain,
        })
    }

    deleteAccount(event) {
        event.preventDefault();
        const elm = $(event.target);
        axios.delete('/api/v1' + $(event.target).attr('action'))
            .then((res) => {
                console.log(res.data);
                if (res.data.success) {
                    elm.parent().parent().modal('hide');
                    this.props.updateDomains();
                }
            }).catch((err) => {
            //
        });
    };

    matchAccountName(event) {
        if ($(event.target).val() === this.props.domain.nickname) {
            this.setState({ disabled: false })
        } else {
            this.setState({ disabled: true })
        }
    }

    render() {
        return (
            <div>
                <div className="modal fade" id={"delete-domain-account-modal-" + this.props.domain.uid} tabIndex="-1" role="dialog"
                     aria-labelledby="delete-exampleModalLabel" aria-hidden="true">
                    <div className="modal-dialog" role="document">
                        <form data-uid={this.props.domain.uid} id={"delete-domain-account-form" + this.props.domain.uid}
                              action={"/domains/" + this.props.domain.uid } method="delete" autoComplete={"off"}
                              onSubmit={this.deleteAccount.bind(this)}>
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h5 className="modal-title" id="delete-exampleModalLabel">Remove this account</h5>
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    <div className="form-group">
                                        <div className="mt-2 mb-4 bg-info p-2 rounded-lg shadow-lg">
                                            <div className="text-white"><i className="ion ion-md-information-circle"></i>
                                                <span id="sign-in-error-text" className="test-white">&nbsp;
                                                    Please type in the name of the account name to confirm.
                                                </span>
                                            </div>
                                        </div>
                                        <label htmlFor="delete-account-nickname">Name</label>
                                        <input className="form-control" type="text" id="delete-account-nickname"
                                               name="delete-account-nickname" placeholder="Name"
                                               onKeyUp={this.matchAccountName.bind(this)}/>
                                    </div>

                                </div>
                                <div className="modal-footer">
                                    <button id={"remove-account-btn"} type="submit"
                                            className="btn btn-danger waves-effect w-100"
                                            disabled={this.state.disabled}>Remove Account
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