import React from "react";

const Card = (props) => {

    const {
        cards,
        links,
        onDeleteCard,
        onSelectCard,
        isLoadedCards,
        isSavingNewCard,
    } = props;

    const handleDeleteClick = function (event, cardTitle) {
        event.preventDefault();

        onDeleteCard(cardTitle);
    };

    const handleClick = function (event, cardTitle) {
        event.preventDefault();

        onSelectCard(cardTitle);
    };

    if (!isLoadedCards) {
        return (
            <div>
                <h3 className="text-center">Loading...</h3>
            </div>
        )
    }

    return (
        <div>
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
                        style={{cursor:'pointer'}}
                        onClick={(event => handleClick(event, card.title))}
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
                            {card.isBlocked && <i className="lock icon" />}
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

export default Card;