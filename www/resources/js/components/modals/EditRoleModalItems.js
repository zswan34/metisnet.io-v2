import React, { Component } from 'react';

export default class EditRoleModalItems extends Component {
    constructor(props) {
        super(props);
        this.state = {
            permissions: this.props.permissions,
            category: this.props.category
        }
    }

    render() {
        const category = this.state.category.split(' ').join('_');
        return (
            <div className="row">
                {this.state.permissions[category].contains.map((contains, index) => {
                    let name = contains['name'].replaceChar(' ', '-');
                    return (
                        <div className={"col-md-6"} key={index}>
                            <label className="custom-control custom-checkbox">
                                <input type="checkbox" className="custom-control-input"
                                id={"edit-permissions-" + name} name={"edit-permissions-" + name}
                                defaultChecked={true}/>
                                    <span className="custom-control-label">{contains['name'].toProperCase()}</span>
                            </label>
                        </div>
                    )
                })}
                {this.state.permissions[category].excludes.map((excludes, index) => {
                    let name = excludes['name'].replaceChar(' ', '-');
                    return (
                        <div className={"col-md-6"} key={index}>
                            <label className="custom-control custom-checkbox">
                                <input type="checkbox" className="custom-control-input"
                                       id={"edit-permissions-" + name} name={"edit-permissions-" + name}
                                />
                                <span className="custom-control-label">{excludes['name'].toProperCase()}</span>
                            </label>
                        </div>
                    )
                })}
            </div>
        )
    }
}