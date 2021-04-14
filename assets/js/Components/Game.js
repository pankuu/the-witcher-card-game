import React, {Component} from 'react'
import ChooseDeckForm from "./ChooseDeckForm";

class Game extends Component {
    constructor(props) {
        super(props);

        this.state = {
            host: '',
            guest: ''
        }

        this.handleFormSubmit = this.handleFormSubmit.bind(this);
        this.handleSelectHost = this.handleSelectHost.bind(this);
        this.handleSelectGuest = this.handleSelectGuest.bind(this);
    }

    handleFormSubmit(event) {
        event.preventDefault();
        const {onPlaySubmit} = this.props;
        const {host, guest} = this.state;
        const numberOfCards = event.target.cards;

        if ('' === host || '' === guest) {
            alert('Choose decks')
        } else {
            onPlaySubmit(host, guest, numberOfCards.value)
        }

        numberOfCards.value = '';
    }

    handleSelectHost(host) {
        this.setState({host})
    }

    handleSelectGuest(guest) {
        this.setState({guest})
    }

    render() {
        return (
            <div>
                <h2>Game:</h2>
                <h5>Host</h5>
                <ChooseDeckForm
                    {...this.props}
                    onNewDeckSelect={this.handleSelectHost}
                />
                <h5>Guest</h5>
                <ChooseDeckForm
                    {...this.props}
                    onNewDeckSelect={this.handleSelectGuest}
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