SELECT DISTINCT Loser.game_date, Teams.team_name
FROM Teams, Games,(SELECT Games.loser_id, Games.game_date
      FROM Teams, Games
      WHERE (YEAR(Games.game_date) = '2016')
      AND ((Games.winner_id = Teams.id)
         AND (Teams.team_name = 'Dallas'))
      )AS Loser
WHERE Loser.loser_id = Teams.id
