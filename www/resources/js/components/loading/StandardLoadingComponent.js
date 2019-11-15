import React, { Component } from 'react';

export default class StandardLoadingComponent extends Component {
    constructor(props) {
        super(props);
    }
    
    render() {
        return (
            <div>
                <div className="d-flex justify-content-center mt-5">
                    <div className="col text-center">
                        <div className="sk-rotating-plane sk-primary"></div>
                        <h4 className={"text-primary mt-0"} style={{fontStyle: 'italic'}}>Loading...</h4>
                    </div>
                </div>
            </div>
        )
    }
}