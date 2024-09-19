import React from 'react';

const PaginatedLinks = ({ data, currentPage, lastPage, onPageChange }) => {
  // Calculate the total number of pages based on the total number of items and items per page
  const totalPages = Math.ceil(data.total / data.per_page);

  // Calculate the range of pages to show in the pagination links
  const range = 2;
  const startPage = Math.max(currentPage - range, 1);
  const endPage = Math.min(currentPage + range, totalPages);

  // Generate the pagination links
  const links = [];
  for (let i = startPage; i <= endPage; i++) {
    const isActive = i === currentPage;
    links.push(
      <li className={`page-item ${isActive ? 'active' : ''}`} key={i}>
        <a
          className="page-link"
          href="#"
          onClick={e => {
            e.preventDefault();
            onPageChange(i);
          }}
        >
          {i}
        </a>
      </li>
    );
  }

  return (
    <nav>
      <ul className="pagination">
        <li className={`page-item ${currentPage === 1 ? 'disabled' : ''}`}>
          <a
            className="page-link"
            href="#"
            onClick={e => {
              e.preventDefault();
              onPageChange(currentPage - 1);
            }}
            aria-label="Previous"
          >
            <i className="feather-icon icon-chevron-left" />
          </a>
        </li>
        {links}
        <li className={`page-item ${currentPage === lastPage ? 'disabled' : ''}`}>
          <a
            className="page-link"
            href="#"
            onClick={e => {
              e.preventDefault();
              onPageChange(currentPage + 1);
            }}
            aria-label="Next"
          >
            <i className="feather-icon icon-chevron-right" />
          </a>
        </li>
      </ul>
    </nav>
  );
};

export default PaginatedLinks;
