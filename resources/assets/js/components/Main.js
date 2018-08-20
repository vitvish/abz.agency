import React, { Component } from "react";
import { render } from "react-dom";
import SortableTree, { getTreeFromFlatData } from "react-sortable-tree";
import axios from 'axios';

class App extends Component {
    constructor(props) {
        super(props);

        this.state = {
            treeData: []
        }
    }

    componentDidMount() {
        // URL for current host
        const host = `http://${location.host}/all`;
        // HTTP GET Request on recive data all employees
            axios.get(host)
                    .then(response =>{
                            const res = response.data;

                            this.setState({
                                treeData: getTreeFromFlatData({
                                    flatData: res.map(node => ({ ...node, title: node.full_name, subtitle: node.position.name })),
                                    getKey: node => node.id, // resolve a node's key
                                    getParentKey: node => node.parent_id, // resolve a node's parent's key
                                    rootKey: 0, // The value of the parent key when there is no parent (i.e., at root level)
                                })
                            })
                        }

                    )
    }

    render() {
        return (
            <div style={{ height: 500 }}>
                <SortableTree
                    treeData={this.state.treeData}
                    onChange={treeData => this.setState({ treeData })}
                />
            </div>
        );
    }
}
export default App;


