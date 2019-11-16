import React, { Component } from 'react';

export default class EditRecordItemModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            record: this.props.record,
            disabled: false
        }
    }

    componentDidMount() {
        this.setState({
            record: this.props.record
        })
    }

    render() {
        let name = this.props.record.name;
        let disabled = false;
        if (name === '@') {
            name = 'aws';
            disabled = true;
        }

        if (name === '*') {
            name = 'apb'
        }
        return (
            <div>
                <div className="modal fade" id={"edit-record-item-modal-" + name} tabIndex="-1" role="dialog"
                     aria-labelledby="edit-record-exampleModalLabel" aria-hidden="true">
                    <div className="modal-dialog modal-sm" role="document">
                        <form data-uid={this.state.record.name} id={"edit-record-item-form-" + this.state.record.name}
                              action={"/domains/edit"} method="post">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h5 className="modal-title" id="edit-record-exampleModalLabel">Edit this record</h5>
                                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    <div className="form-group">
                                        <label htmlFor="edit-account-nickname">Name</label>
                                        <div className="input-group">
                                            <input className="form-control" type="text" id="edit-record-item-name"
                                                   name="edit-record-item-name" placeholder="Name"
                                                   defaultValue={`${this.state.record.name}`} disabled={disabled}/>
                                        <div className="input-group-prepend">
                                            <div className="input-group-text">.metisnet.io</div>
                                        </div>
                                    </div>

                                    </div>
                                    <div className="form-group">
                                        <label htmlFor="edit-record-item-data" className="form-label">Host</label>
                                        <input className={"form-control"} name={"edit-record-item-data"}
                                               defaultValue={this.state.record.data}/>
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="edit-record-item-type" className="form-label">Type</label>
                                        <input className={"form-control"} disabled name={"edit-record-item-type"}
                                               defaultValue={this.state.record.type}/>
                                    </div>
                                </div>
                                <div className="modal-footer">
                                    <button type="button" className="btn btn-default"
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