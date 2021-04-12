import React from "react";

const Cards = (props) => {

    const {cards, links, onDeleteCard, isLoaded, isSavingNewCard, message} = props;

    const handleDeleteClick = function (event, cardTitle) {
        event.preventDefault();

        onDeleteCard(cardTitle);
    };

    if (!isLoaded) {
        return (
            <div>
                <h3 className="text-center">Loading...</h3>
            </div>
        )
    }

    return (
        <div>
            {message && (
                <div className="alert alert-success text-center">
                    {message}
                </div>
            )}
            <h4>Total cards ({links && links.total_items})</h4>
            <table className="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Power</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                {cards.map((card) => (
                    <tr
                        key={card.id}
                    >
                        <td>{card.id}</td>
                        <td>{card.title}</td>
                        <td>{card.power}</td>
                        <td>
                            {!card.isBlocked &&
                            <a href="#" onClick={(event) => handleDeleteClick(event, card.title)}>
                                <i className="trash icon"/>
                            </a>
                            }
                        </td>
                    </tr>
                ))}
                {isSavingNewCard && (
                    <tr>
                        <td
                            colSpan="4"
                            className="text-center"
                            style={{
                                opacity: .5
                            }}
                        >Saving to the database ...
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
        </div>
    );
}

export default Cards;