import Box from "../../components/Admin/Box/Box";
import s from "../../styles/pages/Admin/dashboard.module.scss";
import { FaUser } from "react-icons/fa";
import { SiBookstack } from "react-icons/si";
import { BiCategory } from "react-icons/bi";
import { useAdminContext } from "../../context/AdminContext";

export default function Dashboard() {
  const {
    data: { books, categories, users },
  } = useAdminContext();

  return (
    <>
      <div className={s.wrapper}>
        <Box icon={<FaUser />} title="المستخدمين" value={users} />
        <Box icon={<SiBookstack />} title="المنتجات" value={books} />
        <Box icon={<BiCategory />} title="الاقسام" value={categories} />
      </div>
    </>
  );
}

export async function getStaticProps() {
  const props = {
    admin: true,
    url: process.env.NEXT_PUBLIC_ADMIN_DASHBOARD,
    title: "لوحة التحكم",
  };

  return {
    props: props,
  };
}
