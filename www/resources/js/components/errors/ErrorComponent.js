import React, { Component } from 'react';

export default class ErrorComponent extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className={"row"}>
                <div className="d-flex justify-content-center">
                    <div className="bg-danger">
                        <p>Unable to load component</p>
                    </div>
                </div>
            </div>
        )
    }
}