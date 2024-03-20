fetch('./citylist.json')
  .then(response => response.json())
  .then(cityList => {
    const usCities = cityList.filter(city => city.country === "US");
    const cityNamesMap = {}; // Object to keep track of city names
    
    // Filter out duplicates while keeping one instance of each unique city name
    const uniqueUsCityNames = usCities.reduce((acc, city) => {
      if (!cityNamesMap[city.name]) {
        cityNamesMap[city.name] = true;
        acc.push(city.name);
      }
      return acc;
    }, []);
    
    // Convert the array of city names to JSON string
    const jsonContent = JSON.stringify(uniqueUsCityNames, null, 2);
    
    // Create a Blob containing the JSON data
    const blob = new Blob([jsonContent], { type: 'application/json' });
    
    // Create a link element
    const link = document.createElement('a');
    link.download = 'us_cities.json'; // File name
    link.href = window.URL.createObjectURL(blob);
    
    // Append the link to the document body and trigger a click event
    document.body.appendChild(link);
    link.click();
    
    // Cleanup
    document.body.removeChild(link);
  })
  .catch(error => {
    console.error('Error fetching city list:', error);
  });
