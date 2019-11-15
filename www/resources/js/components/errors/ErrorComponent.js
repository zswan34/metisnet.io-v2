import React, { Component } from 'react';

export default class ErrorComponent extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <div className="d-flex justify-content-center">
                    <div className="bg-danger col-md-4 p-3 rounded-lg shadow-lg">
                        <span className={"text-white"}><i className={"lnr lnr-warning"}></i>
                            &nbsp; An error occurred. Unable to load component.
                        </span>
                    </div>
                </div>
            </div>
        )
    }
}