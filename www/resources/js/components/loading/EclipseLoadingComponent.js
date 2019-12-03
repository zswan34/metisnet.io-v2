import React, { Component } from 'react';

export default class EclipseLoadingComponent extends Component {
    constructor(props) {
        super(props);
    }
    
    render () {
        return (
        <div className="loadingio-spinner-eclipse">
            <div className="ldio">
                <div></div>
            </div>
        </div>
        )
    }
}