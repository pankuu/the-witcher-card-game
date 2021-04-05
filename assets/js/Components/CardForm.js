import React, {Component} from 'react'
import {createCards} from './api/api_cards'


class CardForm extends Component {
    constructor(props) {
        super(props);

        this.state = {
            title: '',
            power: 0
        }
    }

    handleChangePower = event => {
        this.setState({power: event.target.value})
    }

    handleSubmit = (e) => {
        e.preventDefault();
        console.log('Event: Form Submit');
        const data = {
            title: this.state.title,
            power: this.state.power,
        };

        createCards(data)
            .then(cards => {
                console.log(cards)
            })
    }

    handleChangeTitle = event => {
        this.setState({title: event.target.value})
    }

    render() {
        return (
            <div className="container ui">
                <h1>Add card</h1>
                <form className="ui form" onSubmit={() => this.handleSubmit()}>
                    Title:<br/>
                    <input name="title" value={this.state.name} type="text" onChange={this.handleChangeTitle}/><br/>
                    Power:<br/>
                    <input name="power" value={this.state.power} type="number" min="0"
                           onChange={this.handleChangePower}
                    /><br/>
                    <button type ="submit">Add Card</button>
                </form>
            </div>
        )
    }
}

export default CardForm;