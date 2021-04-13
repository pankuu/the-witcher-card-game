import React, {Component} from 'react'
import ChooseDeckForm from "./ChooseDeckForm";

class Game extends Component {
    constructor(props) {
        super(props);

        this.handleFormSubmit = this.handleFormSubmit.bind(this);
    }

    handleFormSubmit(event) {
        event.preventDefault();
        const {onPlaySubmit} = this.props;
        const numberOfCards = event.target.cards;

        onPlaySubmit('Host', 'Guest', numberOfCards.value)

        numberOfCards.value = '';
    }

    render() {
        const {cards} = this.props;

        return (
            <div>
                <h2>Game:</h2>
                <h5>Host</h5>
                <ChooseDeckForm
                    {...this.props}
                    itemSelect={this.itemSelect}
                />
                <h5>Guest</h5>
                <ChooseDeckForm
                    {...this.props}
                    itemSelect={this.itemSelect}
                />
                <form className="form-inline" onSubmit={this.handleFormSubmit}>
                    <div className="form-group">
                        <input
                            placeholder="Number of cards"
                            className="form-control"
                            required="required"
                            id="cards"
                            type="number"
                            min="0"
                        />
                    </div>
                    <div className="form-group">
                        <input type="submit" className="btn btn-primary" value="Play"/>
                    </div>
                </form>
            </div>
        )
    }
}

export default Game;