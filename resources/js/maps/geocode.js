import axios from 'axios';

export async function geocodeAddress(address) {
    const apiKey = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;
    const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=${apiKey}`;

    try {
        const response = await axios.get(url);
        return response.data;
    } catch (error) {
        throw new Error(`Geocoding failed: ${error}`);
    }
}

