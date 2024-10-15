"use client";
import "./profile.css";
import ProfileDataList from "./profileDataList";
import { API_ROUTES } from "@/components/apiRoutes";
import { useEffect, useState } from "react";
import axios from "axios";

const Page = () => {
    const [data, setData] = useState(null);
    const [error, setError] = useState(null);
    const [selectedFile, setSelectedFile] = useState(null);  // Для хранения выбранного файла
    const [avatarUrl, setAvatarUrl] = useState("/images/defaultAvatar.png");  // Ссылка на аватар по умолчанию
    const [isHovered, setIsHovered] = useState(false);  // Для отслеживания наведения на аватар

    const ratingNum = "26";

    // Получение данных профиля
    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(API_ROUTES.GET_PROFILE, {
                    withCredentials: true,
                });
                setData(response.data.data);
                if (response.data.data.avatar) {
                    setAvatarUrl(API_ROUTES.DOMAIN_NAME + response.data.data.avatar);  // Устанавливаем аватар, если он уже есть
                }
            } catch (err) {
                setError(err);
            }
        };

        fetchData();
    }, []);

    // Обработчик выбора файла и автоматическая загрузка
    const handleFileChange = async (event) => {
        const file = event.target.files[0];
        if (file) {
            setSelectedFile(file);
            const imageUrl = URL.createObjectURL(file);
            setAvatarUrl(imageUrl);  // Отображаем превью загруженного файла

            // Автоматическая отправка изображения на сервер после выбора файла
            const formData = new FormData();
            formData.append("image", file);

            try {
                const response = await axios.post(API_ROUTES.UPLOAD_PROFILE_PICTURE, formData, {
                    withCredentials: true,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });

                if (response.status === 200) {
                    alert("Фото профиля успешно загружено!");
                    setAvatarUrl(response.data.profile_picture_url);  // Обновляем URL аватара
                } else {
                    alert("Ошибка при загрузке фото.");
                }
            } catch (error) {
                alert("Ошибка при отправке запроса.");
                console.error(error);
            }
        }
    };

    if (error) {
        return <div>Ошибка: {error.message}</div>;
    }

    if (!data) {
        return <div>Загрузка...</div>;
    }

    return (
        <div className="container d-flex justify-content-center text">
            <div className="row mt-5 mb-5 d-flex justify-content-center col-md-8">
                <div className="user-card p-0">
                    <h3 className="mh d-flex align-content-start">{data.name}</h3>
                    <div className="d-flex justify-content-start">
                        <div
                            className="avatar d-flex justify-content-center align-items-center position-relative"
                            onMouseEnter={() => setIsHovered(true)}  // Показываем кнопку при наведении
                            onMouseLeave={() => setIsHovered(false)}  // Скрываем кнопку при уходе
                        >
                            <img src={avatarUrl} alt="Аватар" className="avatar-image" />

                            {/* Кнопка для загрузки нового фото */}
                            {isHovered && (
                                <div className="upload-overlay">
                                    <input
                                        type="file"
                                        id="fileInput"
                                        className="file-input"
                                        onChange={handleFileChange}  // Автоматически загружаем файл после выбора
                                    />
                                    <label htmlFor="fileInput" className="upload-label">
                                        Загрузить новое фото
                                    </label>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                <div className="p-0 m-0">
                    <ProfileDataList data={data} />
                </div>
            </div>
        </div>
    );
};

export default Page;
