import React, {Component} from 'react'

class DeckForm extends Component {
    constructor(props) {
        super(props);

        this.deckInput = React.createRef();

        this.handleFormSubmit = this.handleFormSubmit.bind(this);
    }

    handleFormSubmit(event) {
        event.preventDefault();
        const {onNewDeckSubmit} = this.props;

        const deckName = this.deckInput.current;

        onNewDeckSubmit(
            deckName.value
        )

        deckName.value = '';
    }

    render() {
        return (
            <div className="container ui">
                <form className="form-inline" onSubmit={this.handleFormSubmit}>
                    <div className="form-group">
                        <input
                            placeholder="Deck name"
                            className="form-control"
                            ref={this.deckInput}
                            required="required"
                            type="text"
                            id="deck_name"/>
                    </div>
                    <div className="form-group">
                        <input type="submit" className="btn btn-primary" value="Add Deck"/>
                    </div>
                </form>
            </div>
        )
    }
}

export default DeckForm;
