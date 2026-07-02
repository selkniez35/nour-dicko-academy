import { Application } from '@hotwired/stimulus';
import { registerControllers } from '@symfony/stimulus-bridge';

export const app = Application.start();
registerControllers(app);
