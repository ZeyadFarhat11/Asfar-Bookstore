import Link from "next/link";
import { IoCloseSharp } from "react-icons/io5";
import { useCartContext } from "../../context/CartContext";
import { cls } from "../../utils/utils";
import s from "./Cart.module.scss";
import CartItem from "./CartItem";

export default function Cart({ cartOpen, setCartOpen }) {
  const { cart: products, setCart } = useCartContext();
  const calcTotal = () => {
    return products
      .map((product) => {
        return parseInt(product.price) * product.qty;
      })
      .reduce((prev, current) => prev + current, 0);
  };

  const close = () => setCartOpen(false);

  return (
    <div className={cls(s.cart, cartOpen ? s.cartActive : "")}>
      <header>
        <button onClick={close}>
          <IoCloseSharp />
        </button>
      </header>
      {products.length === 0 ? (
        <p className="text-center fs-5">لا توجد منتجات.</p>
      ) : (
        <>
          <div className={s.body}>
            <div className={s.products}>
              {products.map((product) => (
                <CartItem key={product.book_id} {...product} />
              ))}
            </div>
          </div>
          <div className={s.total}>المجموع: {calcTotal()} EGP</div>
          <div className={s.btns}>
            <Link href={`/cart`} onClick={close}>
              عرض السلة
            </Link>
            <Link href={`/checkout`} onClick={close}>
              إتمام الطلب
            </Link>
          </div>
        </>
      )}
    </div>
  );
}
