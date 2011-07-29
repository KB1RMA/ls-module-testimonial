<?

	class Testimonial_Actions extends Cms_ActionScope {
		public function statements() {
			$this->data['statements'] = Testimonial_Statement::create()->where('is_enabled=1')->find_all();
		}
	}
	