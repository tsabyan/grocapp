export function useCartAnimation() {
    const animateToCart = (imageElement: HTMLElement, imageUrl: string | null) => {
        if (!imageElement) return;

        // Get the position of the source image
        const sourceRect = imageElement.getBoundingClientRect();

        // Get the position of the cart icon (prefer top header, fallback to bottom nav)
        const cartIcon = document.querySelector('header [data-cart-icon]') as HTMLElement ||
                         document.querySelector('nav [data-cart-icon]') as HTMLElement;
        if (!cartIcon) return;

        const cartRect = cartIcon.getBoundingClientRect();

        // Create a flying image element
        const flyingImage = document.createElement('div');
        flyingImage.style.position = 'fixed';
        flyingImage.style.left = `${sourceRect.left + sourceRect.width / 2}px`;
        flyingImage.style.top = `${sourceRect.top + sourceRect.height / 2}px`;
        flyingImage.style.width = '60px';
        flyingImage.style.height = '60px';
        flyingImage.style.borderRadius = '8px';
        flyingImage.style.overflow = 'hidden';
        flyingImage.style.zIndex = '9999';
        flyingImage.style.pointerEvents = 'none';
        flyingImage.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        flyingImage.style.opacity = '1';
        flyingImage.style.transform = 'translate(-50%, -50%) scale(1)';

        // Add image or placeholder
        if (imageUrl) {
            const img = document.createElement('img');
            img.src = imageUrl;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            flyingImage.appendChild(img);
        } else {
            flyingImage.style.backgroundColor = '#f3f4f6';
        }

        // Add border
        flyingImage.style.border = '2px solid #000';
        flyingImage.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';

        document.body.appendChild(flyingImage);

        // Force reflow
        flyingImage.offsetHeight;

        // Animate to cart
        const targetX = cartRect.left + cartRect.width / 2;
        const targetY = cartRect.top + cartRect.height / 2;

        flyingImage.style.left = `${targetX}px`;
        flyingImage.style.top = `${targetY}px`;
        flyingImage.style.transform = 'translate(-50%, -50%) scale(0.3)';
        flyingImage.style.opacity = '0';

        // Remove element after animation
        setTimeout(() => {
            if (flyingImage.parentNode) {
                flyingImage.parentNode.removeChild(flyingImage);
            }
        }, 600);
    };

    return { animateToCart };
}
