import React from "react";

const Cards = (props) => {

    const {cards, links} = props;

    // const handleDeleteClick = function(event, cardId) {
    //     event.preventDefault();
    //
    //     onDeleteCards(cardId);
    // };

    return (
        <>
            <h2>Total cards ({links && links.total_items})</h2>
            <table>
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
                            // <a href="#" onClick={(event) => handleDeleteClick(event, card.id)}>
                            <i className="trash icon"></i>
                                // </a>
                            }
                        </td>
                    </tr>
                ))}
                </tbody>
            </table>
        </>
    );
}

export default Cards;