import React, {Component} from 'react'

class ChooseDeckForm extends Component {
    constructor(props) {
        super(props);

        this.state = {
            value: ''
        }

        this.handleSelect = this.handleSelect.bind(this)
    }

    handleSelect(e) {
        const {onNewDeckSelect} = this.props
        const value = e.target.value
        onNewDeckSelect(value);
        this.setState({value})
    }

    render() {
        const {decks} = this.props;
        return (
            <div className="form-group">
                <select
                    value={this.state.value}
                    onChange={this.handleSelect}
                    id="deck"
                    required="required"
                    className="form-control"
                >
                    <option value="">Choose Deck</option>
                    {decks && decks.map((deck) => (
                        <option key={deck.id} value={deck.name}>{deck.name}</option>
                    ))}
                </select>
            </div>
        )
    }
}

export default ChooseDeckForm;