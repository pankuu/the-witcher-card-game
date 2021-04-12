import React  from "react";

const DeckCard = (props) => {

    const {selectedDeck, selectedCard, handleSelectedDeckCard} = props

    const handleClick = function (event, deckTitle, cardName) {
        event.preventDefault();

        handleSelectedDeckCard(deckTitle, cardName);
    }

    return (
        <div>
            <h5>Choose deck and cards</h5>
            {selectedDeck && <h6>Deck: {selectedDeck}</h6>}
            {selectedCard && <h6>Card: {selectedCard}</h6>}
            {selectedCard && selectedDeck &&
                <button onClick={(event => handleClick(event, selectedDeck, selectedCard))} type="submit"  className="btn btn-primary">Add card to deck</button>
            }
        </div>
    )

}

export default DeckCard;