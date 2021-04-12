import React, {Component} from 'react'

const ChooseDeckForm = (props) => {

    const {decks, itemSelect}  = props;



    return (
        <form className="form-inline">
            <div className="form-group">
                <label className="sr-only control-label required" htmlFor="deck">
                    Select host?
                </label>
                <select
                    // ref={itemSelect}
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
        </form>
    )
}

export default ChooseDeckForm;