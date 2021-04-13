import React from "react";

const Deck = (props) => {

    const {
        decks,
        isLoadedDecks,
        isSavingNewDeck,
        onSelectDeck,
        onShowDeckCards,
    } = props;

    const handleClick = function (event, deckTitle) {
        event.preventDefault();

        onSelectDeck(deckTitle);
    }

    const handleShowDeckCards = function (event, deckTitle) {
        event.preventDefault()

        onShowDeckCards(deckTitle);
    }

    if (!isLoadedDecks) {
        return (
            <div>
                <h3 className="text-center">Loading...</h3>
            </div>
        )
    }

    return (
        <div>
            <h4>Total Decks ({decks && decks.length})</h4>
            <table className="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                {decks.map((deck) => (
                    <tr
                        key={deck.id}

                    >
                        <td>{deck.id}</td>
                        <td
                            style={{cursor:'pointer'}}
                            onClick={(event) => handleClick(event, deck.name)}
                        >
                            {deck.name}
                        </td>
                        <td style={{cursor:'pointer'}}>
                            <a href="#" onClick={(event => handleShowDeckCards(event, deck.name))}>
                                <i className="angle double right icon" />
                            </a>
                        </td>
                    </tr>
                ))}
                {isSavingNewDeck && (
                    <tr>
                        <td
                            colSpan="4"
                            className="text-center"
                            style={{
                                opacity: .5
                            }}
                        >
                            Saving to the database ...
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
        </div>
    );
}

export default Deck;