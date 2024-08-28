import React from 'react';
import { Pagination, PaginationItem, PaginationLink } from 'reactstrap';

const CustomPagination = ({ currentPage, totalPages, onPageChange }) => {
  const handlePageChange = (page) => {
    if (page > 0 && page <= totalPages) {
      onPageChange(page);
    }
  };

  // Function to generate page numbers
  const generatePageNumbers = () => {
    const pageNumbers = [];
    if (totalPages <= 5) {
      for (let i = 1; i <= totalPages; i++) {
        pageNumbers.push(i);
      }
    } else {
      if (currentPage < 4) {
        for (let i = 1; i <= 5; i++) {
          pageNumbers.push(i);
        }
        pageNumbers.push('...', totalPages);
      } else if (currentPage > totalPages - 3) {
        pageNumbers.push(1, '...');
        for (let i = totalPages - 4; i <= totalPages; i++) {
          pageNumbers.push(i);
        }
      } else {
        pageNumbers.push(1, '...');
        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
          pageNumbers.push(i);
        }
        pageNumbers.push('...', totalPages);
      }
    }
    return pageNumbers;
  };

  const pageNumbers = generatePageNumbers();

  return (
    <Pagination>
      <PaginationItem disabled={currentPage === 1}>
        <PaginationLink
          first
          onClick={() => handlePageChange(1)}
        />
      </PaginationItem>
      <PaginationItem disabled={currentPage === 1}>
        <PaginationLink
          previous
          onClick={() => handlePageChange(currentPage - 1)}
        />
      </PaginationItem>
      {pageNumbers.map((page, index) => (
        page === '...' ? (
          <PaginationItem key={index} disabled>
            <PaginationLink>...</PaginationLink>
          </PaginationItem>
        ) : (
          <PaginationItem key={page} active={page === currentPage}>
            <PaginationLink onClick={() => handlePageChange(page)}>
              {page}
            </PaginationLink>
          </PaginationItem>
        )
      ))}
      <PaginationItem disabled={currentPage === totalPages}>
        <PaginationLink
          next
          onClick={() => handlePageChange(currentPage + 1)}
        />
      </PaginationItem>
      <PaginationItem disabled={currentPage === totalPages}>
        <PaginationLink
          last
          onClick={() => handlePageChange(totalPages)}
        />
      </PaginationItem>
    </Pagination>
  );
};

export default CustomPagination;
