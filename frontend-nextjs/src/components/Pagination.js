import React from 'react'
import "./Pagination.css"
import ActionIconButton from "@/components/buttons/ActionIconButton"

const Pagination = ({ pagination, handlePageChange }) => {
  const { current_page, last_page } = pagination;

  // Определяем диапазон страниц для отображения
  const pageRange = 2; // Количество страниц, которые будут отображаться до и после текущей страницы

  // Функция для создания списка страниц
  const getPageNumbers = () => {
    const pages = [];
    for (let i = 1; i <= last_page; i++) {
      if (
        i <= pageRange * 2 + 1 || // Показываем первые страницы
        i >= current_page - pageRange && i <= current_page + pageRange || // Показываем страницы вокруг текущей
        i > last_page - pageRange // Показываем последние страницы
      ) {
        pages.push(i);
      }
    }
    return pages;
  };

  // Обрабатываем изменение страницы
  const handlePageClick = (page) => {
    if (page > 0 && page <= last_page) {
      handlePageChange(page);
    }
  };

  return (
    <div className='d-flex justify-content-start align-items-center'>
        <ActionIconButton buttonClassName={"pag-icon-button"} className="pag-icon" img="/images/arrow-left.png" onClick={() => handlePageChange(current_page - 1)}
        disabled={current_page === 1}/>

      <div className = "numbers">
        {getPageNumbers().map((page) => (
          <button className={page === current_page ? "selected": "number"}
            key={page}
            onClick={() => handlePageClick(page)}
          >
            {page}
          </button>
        ))}
      </div>
      <ActionIconButton buttonClassName={"pag-icon-button"} className="pag-icon" img="/images/arrow-right.png" onClick={() => handlePageChange(current_page + 1)}
        disabled={current_page === last_page}/>
    </div>
  );
};

export default Pagination;
