SELECT COUNT(*)
FROM Players, Games, Stats, EventTypes
WHERE (MONTH(Games.game_date) = '10'AND Games.id = Stats.game_id)
    AND (Stats.event_id = EventTypes.id AND (EventTypes.event_type = 'rushing'))
    AND (Stats.player_id = Players.id
         AND (Players.first_name = 'Marshawn' AND Players.last_name = 'Lynch'))
