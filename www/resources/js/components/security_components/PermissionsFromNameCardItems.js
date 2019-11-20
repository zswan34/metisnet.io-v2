import React, { Component } from 'react';

export default class PermissionsFromNameCardItems extends Component {
    constructor(props) {
        super(props);
        this.state = {
            category: this.props.category,
            permissions: this.props.permissions,
        }
    }

    render() {
        return (
            <div className="row">
                {this.state.permissions[this.state.category].contains.map((contains, index) => {
                    return (
                        <div className={"col-md-4"} key={index}>
                            <span><i className="lnr lnr-checkmark-circle text-success"></i> &nbsp;
                                {contains['name'].toProperCase()}
                                </span>
                        </div>
                    )
                })}
                {this.state.permissions[this.state.category].excludes.map((excludes, index) => {
                    return (
                        <div className={"col-md-4"} key={index}>
                            <span><i className="lnr lnr-cross-circle text-danger"></i> &nbsp;
                                {excludes['name'].toProperCase()}
                                </span>
                        </div>
                    )
                })}
            </div>
        )
    }
}