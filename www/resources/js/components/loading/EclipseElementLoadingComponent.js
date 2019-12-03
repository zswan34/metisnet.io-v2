import React, { Component } from 'react';

export default class EclipseElementLoadingComponent extends Component {
    constructor(props) {
        super(props);
    }

    render () {
        return (
            <div className="loadingio-spinner-eclipse-element">
                <div className="ldio-element">
                    <div></div>
                </div>
            </div>
        )
    }
}