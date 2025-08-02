# app.py

from flask import Flask, request, jsonify
from flask_cors import CORS
from geopy.distance import geodesic

# Initialize the Flask application
app = Flask(__name__)

# Enable Cross-Origin Resource Sharing (CORS) for the app
CORS(app)

# Define the '/check_proximity' route that accepts POST requests
@app.route('/check_proximity', methods=['POST'])
def check_proximity():
    # Get the JSON data from the incoming request
    data = request.get_json()

    # Extract warehouse and delivery coordinates from the data
    # The coordinates are expected in [latitude, longitude] format
    warehouse_coords = tuple(data['warehouse'])
    delivery_coords = tuple(data['delivery'])

    # Get the radius from the data, default to 250 meters if not provided
    radius = data.get('radius', 250)

    # Calculate the distance between the two points in meters
    distance = geodesic(warehouse_coords, delivery_coords).meters

    # Check if the calculated distance is within the specified radius
    is_within_range = distance <= radius

    # Return the result as a JSON response
    return jsonify({
        'distance': round(distance, 2),
        'within_range': is_within_range
    })

# Run the app in debug mode if the script is executed directly
if __name__ == '__main__':
    app.run(debug=True)