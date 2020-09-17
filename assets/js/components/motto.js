import React from 'react';
import ReactDOM from 'react-dom';

class Motto extends React.Component {
    render() {
        return (
            <p class="lead float-left text-muted">Source code analysis</p>
        );
    }
}

ReactDOM.render(<Motto />, document.getElementById('motto'));