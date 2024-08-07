import "./profile.css"
import ProfileDataList from "./profileDataList";

const Page = () => {
    const userName = "user";
    const ratingNum = "26";

    return (
        <div className="container d-flex justify-content-center text">
            <div className="row mt-5 mb-5 d-flex justify-content-center col-md-8">
                <div className="user-card p-0">
                    <h3 className="mh d-flex align-content-start">{userName}</h3>
                    <div className="d-flex justify-content-start">
                        <div className="avatar d-flex justify-content-center align-items-center">
                            <img src={`${process.env.PUBLIC_URL}/images/defaultAvatar.png`} alt=""/>
                        </div>
                        <div className="">
                            Рейтинг <b>{ratingNum}</b>
                        </div>
                    </div>
                </div>
                <div className="p-0 m-0">
                    <ProfileDataList/>
                </div>
            </div>
        </div>
    );
}

export default Page;
