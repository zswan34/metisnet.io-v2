import React, { Component } from 'react';

export default class StandardLoadingComponent extends Component {
    constructor(props) {
        super(props);
    }
    
    render() {
        return (

            <div>
                <div className="d-flex justify-content-center mt-5">
                    <div className="lds-css col-6" style={{marginLeft: '25%'}}>
                        <div style={{width: '100%', height: '100%'}} className="lds-ripple">
                            <div></div>
                            <div></div>
                        </div>
                        <p className={"text-primary mt-0"} style={{marginLeft: '15%', fontSize: '24px', fontStyle: 'italic'}}>
                            Loading...
                        </p>

                    </div>
                </div>
            </div>
        )
    }
}