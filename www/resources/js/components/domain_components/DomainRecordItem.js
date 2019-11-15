import React, { Component } from 'react';

export default class DomainRecordItem extends Component {
    constructor(props) {
        super(props);
        this.state = {
            record: this.props.record,
            authUser: this.props.user,
            permissions: this.props.user.permissions
        }
    }


    userHasPermission(permission) {
        const permissions = this.state.permissions;
        let match = false;
        for (let i = 0; i < permissions.length; i++) {
            if (permissions[i].name === permission) {
                match = true;
            }
        }
        return match;
    }

    displayControls() {
        const canEdit = this.userHasPermission('edit domain records');
        const canDelete = this.userHasPermission('delete domain records');

        return (
            <div className={"d-block"}>
                {canEdit ? (
                    <button data-record-name={this.props.record.name} onClick={this.editRecord.bind(this)}
                            type={"button"} className={"btn btn-warning btn-sm px-2 mx-1"}>
                        <span className="lnr lnr-pencil"></span> Edit</button>
                ) : null}
                {canDelete && this.props.record.name !== '@' ? (
                    <button data-record-name={this.props.record.name} onClick={this.deleteRecord.bind(this)}
                            type={"button"} className={"btn btn-danger btn-sm px-2 mx-1"}>
                        <span className="lnr lnr-trash"></span> Delete</button>
                ) : null}
            </div>
        )
    }

    editRecord(event) {
        alert($(event.target).data('record-name'));
    }

    deleteRecord(event) {
        alert($(event.target).data('record-name'));
    }

    render() {
        let name = (this.props.record.name === '*') ? this.props.record.name + ' (wildcard)' : this.props.record.name;
        if (name === '@') {
            name = this.props.record.name + ' (Parked)';
        }
        return (
            <div className="list-group-item list-group-item-action flex-column align-items-start">
                <div className="d-flex justify-content-between w-100">
                    <h5 className="mb-1">{`${name}`}</h5>
                    {this.displayControls()}
                </div>
                <div className={"small"}><b><i>Host: </i></b> {`${this.props.record.data}`}</div>
                <div className={"small"}><b><i>Type: </i></b> {`${this.props.record.type}`}</div>
            </div>
        )
    }
}