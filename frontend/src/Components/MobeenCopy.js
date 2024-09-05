import React, { useEffect, useState, useCallback } from 'react';
import { Table, Input, Spinner, ListGroup, ListGroupItem } from 'reactstrap';
import CustomPagination from './Pagination';

function MobeenCopy() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);
  const [itemsPerPage] = useState(10);
  const [totalItems, setTotalItems] = useState(0);
  const [searchQuery, setSearchQuery] = useState("");
  const [suggestions, setSuggestions] = useState([]);
  const [showSuggestions, setShowSuggestions] = useState(false);

  const fetchData = useCallback(() => {
    setLoading(true);
    const url = new URL('http://127.0.0.1:8000/api/project');
    url.searchParams.append('page', currentPage);
    url.searchParams.append('limit', itemsPerPage);
    if (searchQuery) {
      url.searchParams.append('search', searchQuery);
    }

    fetch(url)
      .then(response => response.json())
      .then(data => {
        setData(data.data || []);
        setTotalItems(data.total || 0);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        setLoading(false);
      });
  }, [currentPage, itemsPerPage, searchQuery]);

  useEffect(() => {
    fetchData();
  }, [fetchData]);

  const handleSearch = (event) => {
    const query = event.target.value;
    setSearchQuery(query);
    setCurrentPage(1); // Reset to the first page on search

    if (query.length > 2) {
      fetchSuggestions(query);
    } else {
      setSuggestions([]);
      setShowSuggestions(false);
    }
  };

  const fetchSuggestions = (query) => {
    fetch(`http://127.0.0.1:8000/api/project/suggestions?query=${query}`)
      .then(response => response.json())
      .then(data => {
        setSuggestions(data);
        setShowSuggestions(true);
      })
      .catch(error => {
        console.error('Error fetching suggestions:', error);
      });
  };

  const handleSuggestionClick = (suggestion) => {
    setSearchQuery(suggestion);
    setShowSuggestions(false);
    setCurrentPage(1);
    fetchData(); // Fetch data based on the selected suggestion
  };

  const paginate = (pageNumber) => setCurrentPage(pageNumber);

  const totalPages = Math.ceil(totalItems / itemsPerPage);

  return (
    <div>
      <h1>Mobeen Ashraf</h1>
      <Input
        type="text"
        placeholder="Search by Project Name or Location"
        value={searchQuery}
        onChange={handleSearch}
        className="mb-3"
      />
      {showSuggestions && (
        <ListGroup className="suggestions-list">
          {suggestions.map((suggestion, index) => (
            <ListGroupItem
              key={index}
              onClick={() => handleSuggestionClick(suggestion.name)}
              className="suggestion-item"
            >
              {suggestion.name}
            </ListGroupItem>
          ))}
        </ListGroup>
      )}
      {loading ? (
        <div className="text-center">
          <Spinner style={{ width: '3rem', height: '3rem' }} type="grow" />
          <div>Loading...</div>
        </div>
      ) : (
        <>
          <Table hover className="mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Project Name</th>
                <th>Location</th>
                <th>Due Date</th>
              </tr>
            </thead>
            <tbody>
              {data.map((item) => (
                <tr key={item.id}>
                  <td>{item.id}</td>
                  <td>{item.name}</td>
                  <td>{item.location}</td>
                  <td>{item.due_date}</td>
                </tr>
              ))}
            </tbody>
          </Table>
          <CustomPagination
            currentPage={currentPage}
            totalPages={totalPages}
            onPageChange={paginate}
          />
        </>
      )}
    </div>
  );
}

export default MobeenCopy;
