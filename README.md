# SpotifyTrackSuggester

### This extension has one endpoint `api/suggest`.

#### The endpoint accepts 5 parameters:
- `token`: Your access token for Spotify Authorization.
- `tracks`: An array of track Ids. 
- `limit`: The target size of the list of recommended tracks. Default: 20. Minimum: 1. Maximum: 100.
- `groups`: How many groups for K-Means to create [See Wiki on K-Means](https://en.wikipedia.org/wiki/K-means_clustering).
- `buffer`: Percentage to buffer the max and min of the attributes used to query Spotify. Default: 0.1 Minimum: 0.0 Maximum: 1.0

### How it works
- The application first fetches ['audio features'](https://developer.spotify.com/web-api/get-several-audio-features/) for the supplied tracks ( the more the merrier ).
- Then the audio features are passed to the K-Means Algorithm and groups the tracks by their features: [danceability, energy, speechiness, acousticness, instrumentalness, liveness, valence].
- It's then determined the min & max of each groups attributes.
- The determined attributes are sent in the query to [api.spotify.com/v1/recommendations](https://developer.spotify.com/web-api/get-recommendations) with the first 5 track ids of the group as the seed_tracks.
- Returned is an array of recommendation responses for each group created by K-Means
