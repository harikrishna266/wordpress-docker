import { ComponentFixture, TestBed } from '@angular/core/testing';
import { DesignSelectorComponent } from './design-selector.component';

describe('DesignsSideBarComponent', () => {
  let component: DesignSelectorComponent;
  let fixture: ComponentFixture<DesignSelectorComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [DesignSelectorComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(DesignSelectorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
