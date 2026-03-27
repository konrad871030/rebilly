/** *
To convert a string to a color, we need to hash the string and then use the hash to generate a color.
We can use the following algorithm:
1. Hash the string using the SHA-256 algorithm.
2. Use the hash to generate a color.
3. Return the color.
*/
function stringToColor(str) {
    let hash = 0;
  
    for (let i = 0; i < str.length; i++) {
      hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
  
    let color = '#';
  
    for (let i = 0; i < 3; i++) {
      let value = (hash >> (i * 8)) & 0xFF;
      color += value.toString(16).padStart(2, '0');
    }
  
    return color;
  }